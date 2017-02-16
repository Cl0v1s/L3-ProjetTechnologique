<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 16/02/17
 * Time: 11:49
 */
class Related extends StorageItem
{
    public $service_id;
    public $statut_id;

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
    public function StatutId()
    {
        return $this->statut_id;
    }

    /**
     * @param mixed $statut_id
     */
    public function setStatutId($statut_id)
    {
        $this->statut_id = $statut_id;
    }
    
    
}