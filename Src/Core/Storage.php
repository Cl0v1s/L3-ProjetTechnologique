<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 24/01/17
 * Time: 18:03
 */
interface Storage
{
    public function put($object);

    public function get($object);

    public function remove($object);

    public function has($object);
}