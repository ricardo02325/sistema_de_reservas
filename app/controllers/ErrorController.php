<?php

    namespace app\controllers;

    class ErrorController {
        public function __construct(){}

        public function error404(){
            echo '<h2>Error 404</h2>';
        }
        public function errorMNE(){
            echo '<h2>Error el método no existe</h2>';
        }
    }