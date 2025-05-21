<?php

namespace app\controllers;

// Se eliminan porque no se usan en este programa
// use app\models\posts as posts;
// use app\models\comments as comments;
// use app\models\interactions as inter;
// use Dom\Comment;

use app\models\reservas;

class ReservasController extends Controller {

    public function __construct(){
        parent::__construct();
    }

    public function getReservas($params = null){
        $reserva = new Reservas();
        $reserva->connect();
        $reserva->table = $reserva->conex;
        echo $reserva->all()->get();
    }
}