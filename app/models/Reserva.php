<?php
namespace app\models;

use app\classes\DB;

class Reserva extends DB {
    public $fillable = ['fecha_hora_reserva', 'cantidad_personas', 'estado'];
    public $values = [];
}
