<?php

include_once 'Core/Storage.php';

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
     * @param $table Table in which insert.
     * @param $object
     * @throws Exception
     */
    public function put($table, $object)
    {
        $data = array();
        $sqlstart = "INSERT INTO ".$table."(";
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

    public function get($spec)
    {
        if(is_array($spec) ==  false)
            throw new Exception("$spec needs to be an array[2]{table/type name, id to get}");
        $data = array();
        $data[":table"] = $spec[0];
        $data[":id"] = $spec[1];
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

    public function remove($key)
    {
        // TODO: Implement remove() method.
    }

    public function has($value)
    {
        // TODO: Implement has() method.
    }
}