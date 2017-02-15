<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 15/02/17
 * Time: 15:08
 */
abstract class StorageItem
{
    public $id;

    private $state;



    public function __construct($id = NULL)
    {
        if($id != NULL)
        {
            $this->id = $id;
        }
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function State()
    {
        return $this->state;
    }

    protected function setChanged()
    {
        $this->state = StorageState::ToUpdate;
    }


}