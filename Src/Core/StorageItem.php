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
    private $new;
    private $modified;

    /**
     * @return null
     */
    public function Id()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        if($this->id != NULL)
            $this->id = $id;
        else
            throw new Error("Can't change StorageItem Id.");
    }

    /**
     * Retourne si l'objet est nouveau ou provient de la base
     * @return bool
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Signale à l'objet qu'il a été modifié
     */
    protected function setModified()
    {
        $this->modified = true;
    }

    function __construct($id = NULL)
    {
        if($id != NULL) {
            $this->id = $id;
            $this->new = false;
        }
        else
            $this->new = true;
        $this->modified = false;
    }
}