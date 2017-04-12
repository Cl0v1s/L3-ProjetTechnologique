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
    public $username;
    public $isadmin;
    public $isbanned;
    public $email;
    public $phone;

    public $questions = array(NULL);
    public $status = array(NULL);
    public $services = array(NULL);
    public $responses = array(NULL);

    /**
     * @return mixed
     */
    public function Email()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function Phone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Retourne l'ensemble des questions associés à cet utilisateur
     * @return array
     */
    public function Questions()
    {
        if(!$this->isLoaded($this->questions)) {
            $this->storage->findAllRelated('Question', $this, $this->questions);
        }
        return $this->questions;
    }

    /**
     * Ajoute une question à l'utilisateur
     * @param $question
     */
    public function addQuestion($question)
    {
        $question->setUserId($this->id);
        $this->storage->persist($question);
        array_push($this->questions, $question);
    }

    /**
     * Retourne l'ensemble des réponses postées par cet utilisateur
     * @return array
     */
    public function Responses()
    {
        if(!$this->isLoaded($this->responses)) {
            $this->storage->findAllRelated('Response', $this, $this->responses);
        }
        return $this->responses;
    }

    /**
     * Ajoute une réponse à l'utilisateur
     * @param Response $response
     */
    public function addResponse(Response $response)
    {
        $response->setUserId($this->id);
        $this->storage->persist($response);
        array_push($this->responses, $response);
    }

    /**
     * @return array
     */
    public function Status()
    {
        if(!$this->isLoaded($this->status)) {
            $is = array(NULL);
            $this->storage->findAllRelated('UserStatus', $this, $is);
            $this->status = array();
            foreach ($is as $entry)
            {
                $u = $entry->Status();
                if($u != NULL)
                    array_push($this->status, $u);
            }

        }
        return $this->status;
    }

    /**
     * @return array
     */
    public function Services()
    {
        if(!$this->isLoaded($this->services)) {
            $is = array(NULL);
            $this->storage->findAllRelated('UserService', $this, $is);
            $this->services = array();
            foreach ($is as $entry)
            {
                $u = $entry->Service();
                if($u != NULL)
                    array_push($this->services, $u);
            }

        }
        return $this->services;
    }


    /**
     * @return mixed
     */
    public function Lastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->setChanged();
        $this->lastname = $lastname;
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

    /**
     * @return mixed
     */
    public function Username()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->setChanged();
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function Isadmin()
    {
        return $this->isadmin;
    }

    public function setIsAdmin($value)
    {
        $this->setChanged();
        $this->isadmin = $value;
    }

        public function Isbanned()
    {
        return $this->isbanned;
    }

    public function setIsbanned($value)
    {
        $this->setChanged();
        $this->isbanned = $value;
    }
}