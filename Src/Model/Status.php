<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 16/02/17
 * Time: 17:54
 */
class Status extends StorageItem
{
    public $name;

    private $users = array(NULL);

    /**
     * @return array
     */
    public function Users()
    {
        if(!$this->isLoaded($this->users)) {
            $is = array(NULL);
            $this->storage->findAllRelated('UserStatus', $this, $is);
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