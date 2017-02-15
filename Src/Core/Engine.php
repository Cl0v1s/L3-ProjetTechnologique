<?php

require_once 'vendor/autoload.php';
include_once 'DatabaseStorage.php';

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 22/01/17
 * Time: 16:02
 */

class Engine
{

    private static $instance;

    public static function Instance()
    {
        if(isset(Engine::$instance) ==  false)
        {
            Engine::$instance = new Engine();
        }
        return Engine::$instance;
    }



    public static function autoload($class)
    {
        if(file_exists('Controllers/'.$class.'.php'))
            include_once 'Controllers/'.$class.'.php';
        else if(file_exists('Model/'.$class.'.php'))
            include_once 'Model/'.$class.'.php';
    }

    function __construct()
    {
        $this->persistence = array();
        spl_autoload_register('Engine::autoload');
    }

    public function run()
    {
        $ctx = array();
        $matches = array();

        $class = NULL;
        if(isset($_GET["p"]) == false || strlen($_GET["p"]) <= 0)
            $class = "Default";
        else
            $class = $_GET["p"];

        $uri = "Controllers/".$class."Controller.php";

        if(file_exists($uri) == false) {
            header("Location: /Error/404");
            return;
        }

        $class = $class."Controller";

        preg_match_all("/([^\/]+)/", $_SERVER["REQUEST_URI"], $matches);

        $controller = new $class($matches[0]);
        $controller->run($ctx);
    }
}
