<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 24/01/17
 * Time: 18:03
 */
interface Storage
{
    public function put($key, $value);

    public function get($key);

    public function remove($key);

    public function has($value);
}