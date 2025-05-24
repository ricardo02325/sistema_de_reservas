<?php

namespace app\controllers;

use app\models\vista_reservas as Reservas;
use app\models\reserva;

class ReservasController
{

    public function getReservas()
    {
        header('Content-Type: application/json');

        $reservasModel = new Reservas();
        $reservasModel->connect();
        $reservas = $reservasModel->getAllReservas();

        if (is_string($reservas)) {
            $reservas = json_decode($reservas, true);
        }

        echo json_encode($reservas);
    }

    public function show($params)
    {
        header('Content-Type: application/json');

        $id = $params[0];

        $reserva = new reserva();
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

        if (!isset($_POST['reserva_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Falta ID de reserva']);
            return;
        }

        $id = $_POST['reserva_id'];
        $fecha = $_POST['fecha_hora_reserva'];
        $personas = $_POST['cantidad_personas'];
        $estado = $_POST['estado'];

        $r = new reserva();
        $r->connect();

        $sql = "UPDATE reserva SET 
                fecha_hora_reserva = ?, 
                cantidad_personas = ?, 
                estado = ? 
            WHERE id = ?";

        $stmt = $r->conex->prepare($sql);
        $stmt->bind_param("sisi", $fecha, $personas, $estado, $id);
        $success = $stmt->execute();

        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar la reserva']);
        }
    }
}