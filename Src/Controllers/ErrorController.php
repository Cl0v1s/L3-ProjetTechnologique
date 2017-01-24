<?php

include_once 'Core/Controller.php';
/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 22/01/17
 * Time: 16:41
 */
class ErrorController extends Controller
{
    public function run($ctx)
    {
        $data = array();
        $data["code"] = $ctx["code"];

        $tpl = "Error/".$ctx["code"];

        $view = new View($tpl, $data);
        $view->setTitle("Erreur ".$ctx["code"]);

        $view->show();
    }
}