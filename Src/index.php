<?php

include_once 'Core/Engine.php';

include_once 'Model/User.php';

include_once 'Utils.php';
/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 22/01/17
 * Time: 16:12
 */

Engine::Instance()->setPersistence(new DatabaseStorage("localhost", "L3", "root", "root"));
Engine::Instance()->run();


