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
}