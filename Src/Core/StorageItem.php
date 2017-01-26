<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 25/01/17
 * Time: 15:47
 */
abstract class StorageItem
{
    public $id;

    function __construct($id = NULL)
    {
        if($id != NULL)
            $this->id = $id;
    }
}