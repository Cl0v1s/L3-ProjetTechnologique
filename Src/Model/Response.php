<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 16/02/17
 * Time: 11:50
 */
class Response extends StorageItem
{
    public $content;
    public $points;
    public $date;
    public $user_id;
    public $question_id;

    public function __construct($storage, $id = NULL)
    {
        parent::__construct($storage, $id);
        $date = new DateTime();
        $this->date = $date->Timestamp();
    }

    public function User()
    {
        $user = new User($this->storage, $this->user_id);
        $this->storage->find($user);
        return $user;
    }

    public function Question()
    {
        $question = new Question($this->storage, $this->question_id);
        $this->storage->find($question);
        return $question;
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
     * @return int
     */
    public function Date(): int
    {
        $date = new DateTime();
        $date->setTimestamp($this->date);
        return $date;
    }

    /**
     * @param int $date
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date->getTimestamp();
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

    /**
     * @return mixed
     */
    public function QuestionId()
    {
        return $this->question_id;
    }

    /**
     * @param mixed $question_id
     */
    public function setQuestionId($question_id)
    {
        $this->question_id = $question_id;
    }
    
    
}