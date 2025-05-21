<?php

namespace app\models;

class Reservas extends Model {

    protected $table;
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
        $this->table = 'vista_reservas'; // nombre exacto de la vista
    }

    public function getAllReservas($limit = 100){
        $result = $this->select([
            'reserva_id as id',
            'nombre_usuario as nombre',
            'numero_mesa as num_mesa',
            'date_format(fecha_hora_reserva, "%Y-%m-%d %H:%i") as fecha',
            'cantidad_personas as personas',
            'estado',
            'fecha_creacion'
        ])
        ->orderBy([['fecha_hora_reserva', 'DESC']])
        ->limit($limit)
        ->get();

        return $result;
    }
}