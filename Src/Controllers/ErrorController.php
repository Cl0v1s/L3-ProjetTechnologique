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
    private $code;

    function __construct($params)
    {
        parent::__construct($params);
        $this->code = $params[1];
    }

    public function run($ctx)
    {
        $data = array();
        $data["code"] = $this->code;

        $view = new View("Error/base", $data);
        $view->setTitle("Erreur ".$this->code);
        $view->show();
    }
}