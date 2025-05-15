<?php

namespace app;

use app\App;

//**Para debugueo en desarrollo */
error_reporting(E_ALL);
ini_set('display_errors',1);

require_once __DIR__ . '/../app.php';

//** Aqui inicia la fiesta */

App::run();