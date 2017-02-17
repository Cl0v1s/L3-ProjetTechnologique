<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 17/02/17
 * Time: 11:14
 */
class ServiceStatus extends StorageItem
{
    public $service_id;
    public $status_id;

    public function Status()
    {
        $status = new Status($this->storage, $this->status_id);
        $this->storage->find($status);
        return $status;
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

    /**
     * @return mixed
     */
    public function StatusId()
    {
        return $this->status_id;
    }

    /**
     * @param mixed $status_id
     */
    public function setStatusId($status_id)
    {
        $this->status_id = $status_id;
    }
    
    
    
}