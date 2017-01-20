<?php
/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 20/01/17
 * Time: 19:39
 */

include_once ("Core/Template.php");

$data = array();
$data["Caca"] = "salut";
Template::prepare("test.html", $data);