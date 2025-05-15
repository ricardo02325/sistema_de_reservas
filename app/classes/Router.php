<?php

namespace app\classes;

use app\controllers\ErrorController as ErrorController;

class Router {
    private $uri = '';
    public function __construct(){}

    public function route(){
       $this->filterRequest();
       $controller = $this->getController();
       $method     = $this->getMethod();
       $params     = $this->getParams();

       if( class_exists($controller) ){
            $controller = new $controller;
       }else{
            $controller = new ErrorController();
            $method = 'error404';
       }
       if( !method_exists($controller,$method) ){
            $controller = new ErrorController();
            $method = 'errorMNE';       
       }
       $controller->$method($params);
       return;
    }

    private function filterRequest(){
        $petition = filter_input_array(INPUT_GET);
        //print_r($petition);
        if( isset( $petition['uri'] )){
            $this->uri = $petition['uri'];
            $this->uri = rtrim( $this->uri, '/');
            $this->uri = filter_var($this->uri, FILTER_SANITIZE_URL);
            $this->uri = explode('/',ucfirst(strtolower($this->uri)));
            //print_r( $this->uri );die();
            return;
        }
    }

    private function getController(){
        $controller = 'Home';
        if( isset($this->uri[0]) ){
            $controller = $this->uri[0];
            unset($this->uri[0]);
        }
        $controller = ucfirst($controller);
        if($controller == 'Session') $controller = 'auth\\Session';
        $controller = 'app\controllers\\' . $controller . 'Controller';
        return $controller;
    }

    private function getMethod(){
        $method = 'index';
        if( isset($this->uri[1]) ){
            $method = $this->uri[1];
            unset( $this->uri[1] );
        }
        return $method;
    }

    private function getParams(){
        $params = [];
        if( !empty($this->uri) ){
            $params = $this->uri;
        }
        return $params;
    }

}