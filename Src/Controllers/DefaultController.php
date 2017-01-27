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

    function __construct()
    {
       parent::__construct();
    }

    public function run($ctx)
    {
        $view = new View("index");
        $view->setTitle("Index");
        $view->show();
    }
}