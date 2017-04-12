<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 16/02/17
 * Time: 17:46
 */
class Service extends StorageItem
{
    public $name;
    public $description;
    public $date_start;
    public $date_end;
    public $reported;
    public $category_id;

    public $users = array(NULL);
    public $status = array(NULL);

    /**
     * @return array
     */
    public function Status()
    {
        if(!$this->isLoaded($this->status)) {
            $is = array(NULL);
            $this->storage->findAllRelated('ServiceStatus', $this, $is);
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
    public function Users()
    {
        if(!$this->isLoaded($this->users)) {
            $is = array(NULL);
            $this->storage->findAllRelated('UserService', $this, $is);
            $this->users = array();
            foreach ($is as $entry)
            {
                $u = $entry->User();
                if($u != NULL)
                    array_push($this->users, $u);
            }

        }
        return $this->users;
    }

    public function Category()
    {
        $category = new Category($this->storage, $this->category_id);
        $this->storage->find($category);
        return $category;
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

    /**
     * @return mixed
     */
    public function Description()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function DateStart()
    {
        $date = new DateTime();
        $date->setTimestamp($this->date_start);
        return $date;
    }

    /**
     * @param mixed $date_start
     */
    public function setDateStart($date_start)
    {
        $this->date_start = $date_start->getTimestamp();
    }

    /**
     * @return mixed
     */
    public function DateEnd()
    {
        $date = new DateTime();
        $date->setTimestamp($this->date_end);
        return $date;
    }

    /**
     * @param mixed $date_end
     */
    public function setDateEnd($date_end)
    {
        $this->date_end = $date_end->getTimestamp();
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
    public function CategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }
    
    

}