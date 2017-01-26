<?php

include_once 'Core/Storage.php';

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 25/01/17
 * Time: 19:46
 */
class SessionStorage implements Storage
{


    /**
     * Ajoute un nouvel objet dans le Storage Session
     * @param $object StorageItem Nouvel objet à ajouter. Sa propriété Id doit être unique.
     * @throws Exception
     */
    public function put($object)
    {
        if(get_class($object) != "SessionItem")
            throw new Exception("$object must be SessionItem.");
        session_start();
        $_SESSION[$object["id"]] = $object;
    }

    /**
     * Récupère les données associées à l'objet object
     * @param $object StorageItem Objet vide, dont seule la propriété ID est affectée.
     * @return mixed L'objet rempli
     * @throws Exception
     */
    public function get($object)
    {
        if(get_class($object) != "SessionItem")
            throw new Exception("$object must be SessionItem.");
        session_start();
        $object = $_SESSION[$object["id"]];
        return $object;
    }

    /**
     * Supprime l'objet objet
     * @param $object StorageItem Objet à supprimer
     * @throws Exception
     */
    public function remove($object)
    {
        if(get_class($object) != "SessionItem")
            throw new Exception("$object must be SessionItem.");
        session_start();
        unset($_SESSION[$object["id"]]);
    }

    /**
     * Retourne vrai si l'objet passé en paramètre est dans le Storage
     * @param $object StorageItem Objet dont il faut tester la présence
     * @return bool
     * @throws Exception
     */
    public function has($object)
    {
        if(get_class($object) != "SessionItem")
            throw new Exception("$object must be SessionItem.");
        if(!isset($_SESSION[$object["id"]]))
            return false;
        return true;
    }
}