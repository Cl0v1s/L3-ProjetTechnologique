<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 12/02/17
 * Time: 13:48
 */
class User extends StorageItem
{
    public $firstname;
    public $lastname;
    public $username;
    public $password;
    public $ban_end;

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
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function Lastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function Username()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
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
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function BanEnd()
    {
        $date = new Date();
        $date->setTimestamp($this->ban_end);
        return $date;
    }

    /**
     * @param mixed $ban_end
     */
    public function setBanEnd($ban_end)
    {
        $this->ban_end = $ban_end->getTimestamp();
    }



}