<?php

    namespace app\models;

    use app\classes\DB as DB;

    class Model extends DB {
        public function __construct(){
            parent::__construct();
        }

        public function all(){
            return $this->get();
        }
    }