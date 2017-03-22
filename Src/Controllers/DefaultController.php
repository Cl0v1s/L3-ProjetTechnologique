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
        $action = $_GET["action"];
        if($action=="faireuntruc")
        {
            $this->faireUnTruc();
            return;
        }
        // Si on a pas faire un truc on fait ce qu'il y a en dessous 
        $view = new View("index");
        $view->setTitle("Index");
        $view->show();
    }
    
    public function faireUnTruc()
    {
        // On fait des trucs   
    }
}
