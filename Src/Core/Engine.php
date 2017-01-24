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

    private $persistence;


    function __construct()
    {

    }

    public function setPersistence($storage)
    {
        if(isset($this->persistence))
            throw new Exception("you cant change persistence if already set.");
        if(get_parent_class($storage) != "Storage")
            throw new Exception("Must be a child class of Storage");
        $this->persistence = $storage;
    }

    public function Persistence()
    {
        return $this->persistence;
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