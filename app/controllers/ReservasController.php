<?php

namespace app\controllers;

use app\models\Reservas;

class ReservasController {
    public function getReservas() {
        header('Content-Type: application/json');

        $reservasModel = new Reservas();
        $reservas = $reservasModel->getAllReservas();

        if (is_string($reservas)) {
            $reservas = json_decode($reservas, true); // Lo convierte en array asociativo
        }

        echo json_encode($reservas);
    }

}