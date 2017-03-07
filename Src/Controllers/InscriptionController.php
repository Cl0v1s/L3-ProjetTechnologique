<?php

include_once "Core/Controller.php";

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 22/01/17
 * Time: 16:15
 */
class InscriptionController extends Controller
{

    function __construct($params)
    {
       parent::__construct($params);
    }

    public function run($ctx)
    {
        $view = new View("inscription");
        $view->setTitle("Inscription");
        $view->show();
    }
}