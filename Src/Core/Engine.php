<?php

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


    function __construct()
    {

    }

    public function run()
    {
        $ctx = array();

        $class = NULL;
        if(isset($_GET["p"]) == false)
            $class = "Default";
        else
            $class = $_GET["p"];

        $uri = "Controllers/".$class."Controller.php";

        if(file_exists($uri) == false) {
            $class = "Error";
            $ctx["code"] = 404;
        }

        $class = $class."Controller";

        $controller = new $class();
        $controller->run($ctx);
    }
}

function __autoload($class)
{
    include_once 'Controllers/'.$class.'.php';
}