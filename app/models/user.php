<?php

    namespace app\models;

class user extends Model {
    
    protected $table;
    protected $fillable = [
        'name',
        'username',
        'email',
        'paswd',
        'tipo',
        'activo',
    ];
    public function __construct(){
        parent::__construct();
        $this->table = $this->connect();
    }
    public $values = [];
}