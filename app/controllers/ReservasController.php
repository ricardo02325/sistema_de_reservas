<?php

namespace app\controllers;

use app\models\vista_reservas as Reservas;
use app\models\Reserva;

class ReservasController
{
    public function getReservas()
{
    header('Content-Type: application/json');

    // Obtener filtros desde la URL
    $filtros = [
        'estado' => $_GET['estado'] ?? '',
        'fecha' => $_GET['fecha'] ?? '',
        'usuario' => $_GET['usuario'] ?? '',
    ];

    try {
        $reservasModel = new Reservas();
        $reservas = $reservasModel->getReservasConFiltros($filtros);

        echo json_encode($reservas);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener reservas', 'detalle' => $e->getMessage()]);
    }
}


    public function show($params)
    {
        header('Content-Type: application/json');

        $id = $params[0];

        $reserva = new Reserva();
        $reserva->connect();

        $datos = $reserva->all()->where([['id', $id]])->get();
        $datos = json_decode($datos, true);

        if (!empty($datos)) {
            echo json_encode($datos[0]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Reserva no encontrada']);
        }
    }

    public function update($params = [])
    {
        header('Content-Type: application/json');

        if (!isset($_POST['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Falta ID de reserva']);
            return;
        }

        $id = $_POST['id'];
        $fecha = $_POST['fecha'];
        $personas = $_POST['personas'];
        $estado = $_POST['estado'];

        if (empty($id) || empty($fecha) || empty($personas) || empty($estado)) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan datos para actualizar la reserva']);
            return;
        }

        $fechaFormateada = date('Y-m-d H:i:s', strtotime($fecha));

        $r = new Reserva();
        $r->connect();

        // Aquí está la corrección del nombre de la tabla: reservas (plural)
        $sql = "UPDATE reservas SET 
            fecha_hora_reserva = ?, 
            cantidad_personas = ?, 
            estado = ? 
            WHERE id = ?";

        $stmt = $r->conex->prepare($sql);
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(['error' => 'Error en la preparación de la consulta']);
            return;
        }

        // bind_param: fecha = string, personas = int, estado = string, id = int
        $stmt->bind_param("sisi", $fechaFormateada, $personas, $estado, $id);

        $success = $stmt->execute();

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Reserva actualizada correctamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar la reserva']);
        }

        $stmt->close();
    }

    public function create()
{
    header('Content-Type: application/json');

    $required = ['usuario', 'mesa', 'fecha', 'personas', 'estado'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            http_response_code(400);
            echo json_encode(['error' => "Falta el campo $field"]);
            return;
        }
    }

    // Validar que la cantidad de personas no exceda la capacidad de la mesa
    try {
        $r = new Reserva();
        $r->connect();
        
        $stmt = $r->conex->prepare("SELECT capacidad FROM mesas WHERE id = ?");
        $stmt->bind_param("i", $_POST['mesa']);
        $stmt->execute();
        $result = $stmt->get_result();
        $mesa = $result->fetch_assoc();
        
        if ($_POST['personas'] > $mesa['capacidad']) {
            http_response_code(400);
            echo json_encode(['error' => "La cantidad de personas excede la capacidad de la mesa"]);
            return;
        }
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al validar la mesa', 'details' => $e->getMessage()]);
        return;
    }

    $fechaFormateada = date('Y-m-d H:i:s', strtotime($_POST['fecha']));

    try {
        $r = new Reserva();
        $r->connect();

        $sql = "INSERT INTO reservas (usuario_id, mesa_id, fecha_hora_reserva, cantidad_personas, estado) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $r->conex->prepare($sql);
        if (!$stmt) {
            throw new \Exception("Error en la preparación de la consulta");
        }

        $stmt->bind_param("iisis", $_POST['usuario'], $_POST['mesa'], $fechaFormateada, $_POST['personas'], $_POST['estado']);
        $success = $stmt->execute();

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Reserva creada correctamente',
                'id' => $stmt->insert_id
            ]);
        } else {
            throw new \Exception("Error al ejecutar la consulta");
        }
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Error al crear la reserva',
            'details' => $e->getMessage()
        ]);
    }
}

public function delete($params)
{
    header('Content-Type: application/json');

    if (empty($params[0])) {
        http_response_code(400);
        echo json_encode(['error' => 'Falta ID de reserva']);
        return;
    }

    $id = $params[0];

    try {
        $r = new Reserva();
        $r->connect();

        $sql = "DELETE FROM reservas WHERE id = ?";
        $stmt = $r->conex->prepare($sql);
        
        if (!$stmt) {
            throw new \Exception("Error en la preparación de la consulta");
        }

        $stmt->bind_param("i", $id);
        $success = $stmt->execute();

        if ($success && $stmt->affected_rows > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Reserva eliminada correctamente'
            ]);
        } else {
            echo json_encode([
                'error' => 'No se encontró la reserva o no se pudo eliminar'
            ]);
        }
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Error al eliminar la reserva',
            'details' => $e->getMessage()
        ]);
    }
}

public function getUsuarios()
{
    header('Content-Type: application/json');
    
    try {
        $r = new Reserva();
        $r->connect();
        
        // Consulta para obtener usuarios activos (asumiendo que todos los usuarios pueden hacer reservas)
        $sql = "SELECT u.id, CONCAT(u.primer_nombre, ' ', u.primer_apellido) AS nombre 
                FROM usuarios u
                JOIN credenciales_login cl ON u.id = cl.usuario_id
                ORDER BY u.primer_nombre, u.primer_apellido";
        
        $result = $r->conex->query($sql);
        
        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = [
                'id' => $row['id'],
                'nombre' => $row['nombre']
            ];
        }
        
        echo json_encode($usuarios);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener usuarios', 'details' => $e->getMessage()]);
    }
}

public function getMesasDisponibles()
{
    header('Content-Type: application/json');
    
    try {
        $r = new Reserva();
        $r->connect();
        
        // Consulta para obtener mesas disponibles
        $sql = "SELECT id, numero_mesa, capacidad 
                FROM mesas 
                WHERE tipo != 'reservada'
                ORDER BY numero_mesa";
        
        $result = $r->conex->query($sql);
        
        $mesas = [];
        while ($row = $result->fetch_assoc()) {
            $mesas[] = [
                'id' => $row['id'],
                'numero' => $row['numero_mesa'],
                'capacidad' => $row['capacidad']
            ];
        }
        
        echo json_encode($mesas);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener mesas', 'details' => $e->getMessage()]);
    }
}
}
    