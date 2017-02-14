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
        if($object->isNew())
            $this->put_new($object);
    }

    private function put_new($object)
    {
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
        $object =  new $data[":table"](-1);
        $object = $this->build_object($object, $results[0]);
        return $object;
    }

    /**
     * Règles les attributs d'un objet à partir de resultats classés sous forme de tableau
     * @param $object objet à régler
     * @param $results données de la base
     * @return mixed objet réglé
     * @throws Exception
     */
    private function build_object($object, $results)
    {
        foreach ($object as $key => $value)
        {
            if(is_array($object[$key]) == false)
                $object[$key] = $results[$key];
            else
            {
                $data = array();
                $data[":table"] = substr($key, 0, -1); //Suppression du -s
                $data[":stranger_key"] = strtolower(get_class($object))."_id";
                $data[":id"] = $object["id"];
                $sql = "SELECT * from :table WHERE :stranger_key=:id";
                $request = $this->pdo->prepare($sql);
                $sub_results = $request->execute($data);
                if($sub_results != true)
                    throw new Exception("The get operation failed.");
                $sub_results = $request->fetchAll();
                foreach ($sub_results as $entry)
                {
                    $sub_object = new $data[":table"](-1);
                    $sub_object = $this->build_object($sub_object, $entry);
                    array_push($object[$key], $sub_object);
                }
            }
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