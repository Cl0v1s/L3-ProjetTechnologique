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
        $this->data["code"] = $ctx["code"];

        $this->setTitle("Erreur ".$ctx["code"]);

        $tpl = "Error/".$ctx["code"];

        Template::process($tpl, $this->data);
    }
}