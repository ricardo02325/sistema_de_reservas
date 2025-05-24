<?php
    namespace app\models;

    use app\classes\DB;

    class reserva extends DB {
    public $fillable = ['fecha_hora_reserva', 'cantidad_personas', 'estado'];
    public $values = [];
    }