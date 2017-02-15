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
        $s = new DatabaseStorage("localhost", "L3", "root", "root");
        
        $user = new User(37);
        $s->find($user);
        echo $user->lastname;
        $user->setLastname("Teneur");
        $s->find($user);
        echo $user->lastname;

        $s->flush();



        $view = new View("index");
        $view->setTitle("Index");
        $view->show();
    }
}