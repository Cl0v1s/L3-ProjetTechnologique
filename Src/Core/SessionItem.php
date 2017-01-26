<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 26/01/17
 * Time: 11:55
 */
class SessionItem extends StorageItem
{
    public $value;

    function __construct($id, $value)
    {
        parent::__construct($id);
        $this->value = $value;
    }
}