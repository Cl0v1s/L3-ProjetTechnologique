<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 16/02/17
 * Time: 10:51
 */
class Question extends StorageItem
{
    public $title;
    public $content;
    public $points;
    public $date;
    public $reported;
    public $subject_id;
    public $user_id;

    public $responses = array(NULL);

    public function __construct($storage, $id = NULL)
    {
        parent::__construct($storage, $id);
        $date = new DateTime();
        $this->date = $date->getTimestamp();
    }

    /**
     * Retourne l'ensemble des responses associés à cet utilisateur
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
     * Ajoute une response à l'utilisateur
     * @param $response
     */
    public function addResponse(Response $response)
    {
        $response->setQuestionId($this->id);
        $this->storage->persist($response);
        array_push($this->responses, $response);
    }

    public function Subject()
    {
        $subject = new Subject($this->storage, $this->subject_id);
        $this->storage->find($subject);
        return $subject;
    }

    public function User()
    {
        $user = new User($this->storage, $this->user_id);
        $this->storage->find($user);
        return $user;
    }


    /**
     * @return mixed
     */
    public function Title()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function Content()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function Points()
    {
        return $this->points;
    }

    /**
     * @param mixed $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * @return mixed
     */
    public function Date()
    {
        $date = new DateTime();
        $date->setTimestamp($this->date);
        return $date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date->getTimestamp();
    }

    /**
     * @return mixed
     */
    public function Reported()
    {
        return $this->reported;
    }

    /**
     * @param mixed $reported
     */
    public function setReported($reported)
    {
        $this->reported = $reported;
    }

    /**
     * @return mixed
     */
    public function SubjectId()
    {
        return $this->subject_id;
    }

    /**
     * @param mixed $subject_id
     */
    public function setSubjectId($subject_id)
    {
        $this->subject_id = $subject_id;
    }

    /**
     * @return mixed
     */
    public function UserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    
    

}