<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 12/02/17
 * Time: 14:27
 */
class Answer extends StorageItem
{
    public $content;
    public $points;
    public $date;
    public $reported;

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
        $date = new Date();
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
    
    
}