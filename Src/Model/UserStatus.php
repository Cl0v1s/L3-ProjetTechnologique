<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 16/02/17
 * Time: 11:48
 */
class UserStatus extends StorageItem
{
    public $user_id;
    public $status_id;

    /**
     * @return mixed
     */
    public function UserId()
    {
        return $this->user_id;
    }

    public function User()
    {
        $user = new User($this->storage, $this->UserId());
        $user = $this->storage->find($user);
        return $user;
    }

    public function Status()
    {
        $status = new Status($this->storage, $this->StatusId());
        $status = $this->storage->find($status);
        return $status;
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
    public function StatusId()
    {
        return $this->status_id;
    }

    /**
     * @param mixed $statut_id
     */
    public function setStatusId($status_id)
    {
        $this->status_id = $status_id;
    }
    
    
}