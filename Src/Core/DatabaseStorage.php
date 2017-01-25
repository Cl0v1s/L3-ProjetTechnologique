<?php

include_once 'Core/Storage.php';
include_once  'Core/StorageItem.php';

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 24/01/17
 * Time: 18:08
 */
class DatabaseStorage implements Storage
{

    private $pdo;

    function __construct($host, $database, $username, $password)
    {
        $this->pdo = new PDO("mysql:host=".$host.";dbname=".$database, $username, $password);
    }


    /**
     * Insert object into table for persistence
     * @param $object StorageItem object to insert
     * @throws Exception
     */
    public function put($object)
    {
        if(get_parent_class($object) != "StorageItem")
            throw new Exception("$object must be StorageItem.");
        $data = array();
        $sqlstart = "INSERT INTO ".get_class($object)."(";
        $sqlend = "VALUES (";
        foreach ($object as $key => $value)
        {
            if($value == NULL)
                continue;
            $sqlstart = $sqlstart.$key.",";
            $sqlend = $sqlend.":".$value.",";
            $data[":".$key] = $value;
        }
        $sqlstart = rtrim($sqlstart,",").")";
        $sqlend = rtrim($sqlend, ",").")";
        $sql = $sqlstart." ".$sqlend;
        $request = $this->pdo->prepare($sql);
        $res = $request->execute($data);
        if($res != true)
        {
            throw new Exception("The put operation failed.");
        }
    }

    /**
     * Récupềre un objet depuis une table de la base de données en fonction de son id
     * @param $object StorageItem objet vide à initialiser
     * @return null|mixed L'objet issu de la base de données
     * @throws Exception
     */
    public function get($object)
    {
        if(get_parent_class($object) != "StorageItem")
            throw new Exception("$object must be StorageItem.");
        $data = array();
        $data[":table"] = get_class($object);
        $data[":id"] = $object["id"];
        $sql = "SELECT * from :table WHERE id=:id";
        $request = $this->pdo->prepare($sql);
        $results = $request->execute($data);
        if($results != true)
            throw new Exception("The get operation failed.");
        $results = $request->fetchAll();
        if(count($results) < 1)
            return NULL;
        else if(count($results) > 1)
            throw new Exception("Your database is inconsistent. Multiple entries have same id. Please correct it.");
        $object =  new $data[":table"]();
        foreach ($object as $key => $value)
        {
            $object[$key] = $results[0][$key];
        }
        return $object;
    }

    /**
     * Supprime l'objet en paramètre de la persistance
     * @param $object StorageItem Objet à supprimer de la persistance
     * @return null
     * @throws Exception
     */
    public function remove($object)
    {
        if(get_parent_class($object) != "StorageItem")
            throw new Exception("$object must be StorageItem.");
        $data = array();
        $data[":table"] = get_class($object);
        $data[":id"] = $object["id"];
        $sql = "DELETE FROM :table WHERE id=:id";
        $request = $this->pdo->prepare($sql);
        $results = $request->execute($data);
        if($results != true)
            throw new Exception("The get operation failed.");
        return NULL;
    }

    /**
     * Vérifie si la persistance dispose de l'objet en mémoire
     * @param $object StorageItem Objet dont il faut tester la présence
     * @return bool
     * @throws Exception
     */
    public function has($object)
    {
        if(get_parent_class($object) != "StorageItem")
            throw new Exception("$object must be StorageItem.");
        if($this->get($object) != NULL)
            return true;
        return false;
    }
}