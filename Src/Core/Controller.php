<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 22/01/17
 * Time: 16:11
 */

include_once 'Core/Template.php';

abstract class Controller
{
    protected $data;

    function __construct()
    {
        $this->data = array();
        $this->data["__title"] = get_class($this);
    }

    public function setTitle($title)
    {
        $this->data["__title"] = $title;
    }

    abstract public function run($ctx);
}