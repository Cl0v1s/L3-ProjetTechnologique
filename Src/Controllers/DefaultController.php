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
        $this->display();
    }
    
    public function display(){
        $data = Utils::SessionVariables();
        $view = new View("index", $data);
        $view->setTitle("Accueil");
        $view->show();
    }
}