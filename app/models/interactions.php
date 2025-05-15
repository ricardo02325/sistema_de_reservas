<?php

    namespace app\models;

class interactions extends Model {
    
    protected $table;
    protected $fillable = [
        'postId',
        'userId',
        'tipo'
    ];
    public function __construct(){
        parent::__construct();
        $this->table = $this->connect();
    }
    public $values = [];

    public function toggleLike($pid, $uid, $t = 1){
        $result = $this-> count()
                        ->where([['userId', $uid], ['postId', $pid]])
                        ->get();
        if( json_decode($result) [0] -> tt == 0){
            $this -> values = [$uid, $pid,$t];
            $this -> create();
        }else{
            $this -> where( [[ 'userId', $uid], ['postId', $pid]] )
                  ->delete();
        }
        return;
    }
}