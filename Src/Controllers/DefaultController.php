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

        $user = new User($s, 37);
        $s->find($user);
        $subject = new Subject($s, 1);
        $s->find($subject);
        $question = new Question($s,2);
        $s->find($question);
        echo $question->Title();
        $s->remove($question);



        $s->flush();



        $view = new View("index");
        $view->setTitle("Index");
        $view->show();
    }
}