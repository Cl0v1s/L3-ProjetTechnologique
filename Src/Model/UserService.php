<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 16/02/17
 * Time: 19:55
 */
class UserService extends StorageItem
{
    public $user_id;
    public $service_id;

    public function User()
    {
        $user = new User($this->storage, $this->user_id);
        $this->storage->find($user);
        return $user;
    }

    public function Service()
    {
        $service = new Service($this->storage, $this->service_id);
        $this->storage->find($service);
        return $service;
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
    public function ServiceId()
    {
        return $this->service_id;
    }

    /**
     * @param mixed $service_id
     */
    public function setServiceId($service_id)
    {
        $this->service_id = $service_id;
    }
    
    

}