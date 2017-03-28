<?php
include_once "Core/Controller.php";
/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 22/01/17
 * Time: 16:15
 */
class DefaultController extends Controller
{
    function __construct($params)
    {
       parent::__construct($params);
    }
    public function run($ctx)
    {
        if(!isset($_GET["action"])){
            $this->display();
        }else{
            $action = $_GET["action"];
            switch($action){
                case 'faireUnTruc':
                    return;
            }
        }
    }
    
    public function display(){
        if(isset($_SESSION["Admin"])){
            $data["admin"] = true;
            $data["user"] = false;
        }else{
            $data["admin"] = false;
            $data["user"] = true;
        }
        if(isset($_SESSION["Admin"])){
            $data["admin"] = true;
            $data["user"] = false;
        }else{
            $data["admin"] = false;
            $data["user"] = true;
        }
        if(isset($_SESSION["User"])){
            $data["connected"] = true;
            $data["disconnected"] = false;
        }else{
            $data["disconnected"] = true;
            $data["connected"] = false;
        }

        $view = new View("index", $data);
        $view->setTitle("index");
        $view->show();
    }
}