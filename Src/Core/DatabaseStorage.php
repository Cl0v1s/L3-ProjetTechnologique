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
        if($res != 1)
        {
            throw new Exception("The put operation failed.");
        }
    }

    public function get($key)
    {
        // TODO: Implement get() method.
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