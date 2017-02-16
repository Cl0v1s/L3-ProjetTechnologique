<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 16/02/17
 * Time: 11:43
 */
class Category extends StorageItem
{
    public $name;

    public $services = array(NULL);

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
     * @return array
     */
    public function Services(): array
    {
        if(!$this->isLoaded($this->services))
            $this->storage->findAllRelated('Service', $this, $this->services);
        return $this->services;
    }

    /**
     * @param array $services
     */
    public function addService($service)
    {
        $service->setCategoryId($this->id);
        $this->storage->persist($service);
        array_push($this->questions, $service);
    }
    
    
}