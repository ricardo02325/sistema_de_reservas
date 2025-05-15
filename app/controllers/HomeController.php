<?php

namespace app\controllers;

use app\classes\View as View;
use app\controllers\auth\SessionController as SC;

class HomeController extends Controller {
    public function __construct(){
        parent::__construct();
    }

    public function index($params = null){
        $response = [
            'ua' => SC::sessionValidate() ?? ['sv' => 0], //el doble ? sirve para compribar si la variable es nula o no
            'title' => 'ForoFIE',
            'code' => 200,
        ];
        View::render('home',$response);
    }
}