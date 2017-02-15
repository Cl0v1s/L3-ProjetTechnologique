<?php

include_once 'Core/StorageItem.php';

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 15/02/17
 * Time: 15:08
 */
class User extends StorageItem
{
    public $lastname;
    public $firstname;
    public $password;

    /**
     * @return mixed
     */
    public function Lastname()
    {
        return $this->lastname;
    }

    public function setLastname($value)
    {
        $this->setChanged();
        $this->lastname = $value;
    }

    /**
     * @return mixed
     */
    public function Firstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->setChanged();
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function Password()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->setChanged();
        $this->password = $password;
    }


}