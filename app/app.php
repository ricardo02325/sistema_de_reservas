<?php 

namespace app;

//**Cosas */

use app\classes\Autoloader as Autoloader;
use app\classes\Router as Router;
use app\controllers\auth\SessionController as SC;

//**Para debugueo en desarrollo */
error_reporting(E_ALL);
ini_set('display_errors',1);

class App {

    public function __construct(){
        $this->init();
    }

    private function init(){
        $this->initConfig();
        $this->initFunctions();
        $this->initAutoloader();
        $this->initSession();
        $this->initRouter();
    }

    private function initConfig(){
        if(!file_exists(__DIR__ . '/config.php')){
            die('No se encontró el archivo de configuración');
        }
        require_once __DIR__ . '/config.php';
        return;
    }
    private function initFunctions(){
        if(!file_exists(FUNCTIONS . '/main_functions.php')){
            die('No se encontró el archivo de funciones de usuario');
        }
        require_once FUNCTIONS . '/main_functions.php';
        return;
    }


    private function initAutoloader(){
        if(!file_exists(CLASSES . '/Autoloader.php')){
            die('No se encontró el archivo Autoloader.php');
        }
        require_once CLASSES . '/Autoloader.php';
        Autoloader::register();
        return;
    }


    private function initSession(){
        SC::sessionValidate();
    }


    private function initRouter(){
/*         if(!file_exists(CLASSES . '/Router.php')){
            die('No se encontró el archivo Router.php');
        }
        require_once CLASSES . '/Router.php'; */
        $router = new Router();
        $router->route();
    }


    public static function run(){
        $app = new self();
        return;
    }
}