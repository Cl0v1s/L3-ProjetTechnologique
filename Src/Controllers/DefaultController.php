<?php
include_once "Core/Controller.php";
include_once "Session.php";
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
        $data = sessionVariables();
        $view = new View("index", $data);
        $view->setTitle("index");
        $view->show();
    }
}