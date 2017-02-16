<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 16/02/17
 * Time: 11:06
 */
class Subject extends StorageItem
{
    public $name;

    public $questions = array([NULL]);


    /**
     * Retourne l'ensemble des questions associés à ce sujet
     * @return array
     */
    public function Questions()
    {
        if(!$this->isLoaded($this->questions))
            $this->storage->findAllRelated('Question', $this, $this->questions);
        return $this->questions;
    }

    /**
     * Ajoute une question à ce sujet
     * @param $question
     */
    public function addQuestion($question)
    {
        $question->setSubjectId($this->id);
        $this->storage->persist($question);
        array_push($this->questions, $question);
    }

    /**
     * @return mixed
     */
    public function Name()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }



}