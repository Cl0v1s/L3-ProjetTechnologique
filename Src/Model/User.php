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

    public $questions = array(NULL);

    /**
     * Retourne l'ensemble des questions associés à cet utilisateur
     * @return array
     */
    public function Questions()
    {
        if(!$this->isLoaded($this->questions)) {
            echo "getiing";
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