<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 15/02/17
 * Time: 15:10
 */
 abstract class StorageState
 {
     const ToInsert = 1;
     const ToUpdate = 2;
     const UpToDate = 0;
     const ToDelete = 3;
 }


class DatabaseStorage
{
    private $pdo;
    private $objects;

    function __construct($host, $database, $username, $password)
    {
        $this->pdo = new PDO("mysql:host=".$host.";dbname=".$database, $username, $password);
        $this->objects = array();
    }

    public function findAllRelated($class, &$object, &$destination)
    {
        $sql = "SELECT * from :table WHERE :stranger_key=:id";
        $data = array();
        $data[":id"] = $object->id;
        $sql = str_replace(":table", $class, $sql);
        $sql = str_replace(":stranger_key", get_class($object)."_id", $sql);
        $request = $this->pdo->prepare($sql);
        $results = $request->execute($data);
        if($results != true)
            throw new Exception("An error occured while retrieving from database.");
        $results = $request->fetchAll();
        $related = array();
        foreach ($results as $result)
        {
            $inst = new $class($this);
            foreach ($inst as $key => $value) {
                if (is_array($value) == false)
                    $inst->$key = $result[$key];

            }
            $this->persist($inst, StorageState::UpToDate);
            array_push($related, $inst);
        }
        $destination = $related;
    }

    public function find(&$object)
    {
        if($object->id == NULL || !isset($object->id))
            throw new Exception("Searched object musts have an Id.");
        if(isset($this->objects[get_class($object)][$object->id])) {
            $object = $this->objects[get_class($object)][$object->id];
            return $this->objects[get_class($object)][$object->id];
        }
        $sql = "SELECT * from :table WHERE id=:id";
        $data = array();
        $data[":id"] = $object->id;
        $sql = str_replace(":table", get_class($object), $sql);
        $request = $this->pdo->prepare($sql);
        $results = $request->execute($data);
        if($results != true)
            throw new Exception("An error occured while retrieving from database.");
        $results = $request->fetchAll();
        if(count($results) < 1)
            return NULL;
        else if(count($results) > 1)
            throw new Exception("Your database is inconsistent. Multiple entries have same id. Please correct it.");
        $results = $results[0];
        foreach ($object as $key => $value) {
            if (is_array($value) == false)
                $object->$key = $results[$key];

        }
        $this->persist($object, StorageState::UpToDate);
        return $object;
    }

    public function remove(&$object)
    {
        if(isset($this->objects[get_class($object)]) && isset($this->objects[get_class($object)][$object->id]))
            $object->setState(StorageState::ToDelete);
    }

    public function persist(&$object, $state = StorageState::ToInsert)
    {
        if(isset($this->objects[get_class($object)]))
        {
            if($state > $object->State())
                $object->setState($state);
            $this->objects[get_class($object)][$object->id] = $object;
        }
        else
        {
            $this->objects[get_class($object)]  =array();
            $this->persist($object, $state);
        }
    }

    public function flush()
    {
        foreach ($this->objects as $key => $table)
        {
            foreach ($table as $k => $entry)
            {
                if($entry->State() === StorageState::ToInsert)
                {
                    $this->insert($entry);
                }
                else if($entry->State() == StorageState::ToUpdate)
                {
                    $this->update($entry);
                }
                else if($entry->State() == StorageState::ToDelete)
                {
                    $this->delete($entry);
                }
                foreach ($entry as $key => $value) {
                    if (is_array($value) == true)
                        $entry->unload($entry->$key);

                }
            }
        }
    }

    private function delete(&$object)
    {
        $sql = "DELETE FROM ".get_class($object)." WHERE id=:id";
        $data = array();
        $data[":id"] = $object->id;
        $request = $this->pdo->prepare($sql);
        $results = $request->execute($data);
        if($results != true)
            throw new Exception("An error occured while deleting from database.");
        unset($this->objects[get_class($object)][$object->id]);
    }

    private function update(&$object)
    {
        $sql = "UPDATE :table SET :values WHERE id=:id";
        $data = array();
        $data[":table"] = get_class($object);
        $data[":values"] = "";
        foreach ($object as $key => $value)
        {
            if(is_array($value))
                continue;
            if(!isset($value) || $value == NULL)
                continue;
            $data[":values"] .= $key." = '".$value."',";
        }
        $data[":values"] = substr($data[":values"], 0, -1);

        $sql = str_replace(":table", $data[":table"], $sql);
        $sql = str_replace(":values", $data[":values"], $sql);
        $request = $this->pdo->prepare($sql);
        $results = $request->execute([":id" => $object->id]);
        if($results != true)
            throw new Exception("An error occured while updating database.");
        $object->setState(StorageState::UpToDate);
    }

    private function insert(&$object)
    {
        $sql = "INSERT INTO :table (:fields) VALUES (:values)";
        $data = array();
        $data[":table"] = get_class($object);
        $data[":fields"] = "";
        $data[":values"] = "";
        foreach ($object as $key => $value)
        {
            if(is_array($value))
                continue;
            if(!isset($value) || $value == NULL)
                continue;
            $data[":fields"] .= $key.",";
            $data[":values"] .= "'".$value."',";
        }
        $data[":fields"] = substr($data[":fields"], 0, -1);
        $data[":values"] = substr($data[":values"], 0, -1);

        $sql = str_replace(":table", $data[":table"], $sql);
        $sql = str_replace(":fields", $data[":fields"], $sql);
        $sql = str_replace(":values", $data[":values"], $sql);
        $request = $this->pdo->prepare($sql);
        $results = $request->execute($data);
        if($results != true)
            throw new Exception("An error occured while inserting in database.");
        $object->id = $this->pdo->lastInsertId();
        $object->setState(StorageState::UpToDate);
    }

}