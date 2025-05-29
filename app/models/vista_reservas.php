<?php

namespace app\models;

use app\classes\DB;

class vista_reservas extends DB {

    protected string $table = 'vista_reservas';

    protected $fillable = [
        'nombre_usuario',
        'numero_mesa',
        'fecha_hora_reserva',
        'cantidad_personas',
        'estado',
        'fecha_creacion'
    ];

    public function __construct(){
        parent::__construct();

        // Asegúrate de que la conexión se realice correctamente
        $this->connect();
    }

    public function getAllReservas($limit = 100){
        try {
            $data = $this->select(['*'])
                         ->orderBy([['fecha_hora_reserva', 'DESC']])
                         ->limit($limit)
                         ->get();

            if (empty($data)) {
                error_log("⚠️ Modelo Reservas: La consulta no devolvió datos.");
            }

            return $data;
        } catch (\Exception $e) {
            error_log("❌ Error en getAllReservas(): " . $e->getMessage());
            return []; // Retorna array vacío si hay error
        }
    }

public function getReservasConFiltros($filtros = [])
{
    $this->connect();

    $condiciones = [];
    $parametros = [];
    $tipos = '';

    if (isset($filtros['estado']) && $filtros['estado'] !== '') {
        $condiciones[] = 'estado = ?';
        $parametros[] = $filtros['estado'];
        $tipos .= 's';
    }

    if (isset($filtros['fecha']) && $filtros['fecha'] !== '') {
        $condiciones[] = 'DATE(fecha_hora_reserva) = ?';
        $parametros[] = $filtros['fecha'];
        $tipos .= 's';
    }

    if (isset($filtros['usuario']) && $filtros['usuario'] !== '') {
        $condiciones[] = 'nombre_usuario = ?';
        $parametros[] = $filtros['usuario'];
        $tipos .= 's';
    }

    $where = '';
    if (!empty($condiciones)) {
        $where = 'WHERE ' . implode(' AND ', $condiciones);
    }

    $sql = "SELECT * FROM vista_reservas $where ORDER BY fecha_hora_reserva DESC";

    $stmt = $this->conex->prepare($sql);

    if (!$stmt) {
        error_log("❌ Error preparando consulta en getReservasConFiltros(): " . $this->conex->error);
        return [];
    }

    if (!empty($parametros)) {
        $stmt->bind_param($tipos, ...$parametros);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}


}