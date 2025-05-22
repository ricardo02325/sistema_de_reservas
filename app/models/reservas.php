<?php

namespace app\models;

use app\classes\DB;

class Reservas extends DB {

    protected string $table = 'vista_reservas'; // <- Se declara aquí correctamente

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
        $this->connect();
    }

    public function getAllReservas($limit = 100){
        return $this->select(['*'])
                    ->orderBy([['fecha_hora_reserva', 'DESC']])
                    ->limit($limit)
                    ->get();
    }
}