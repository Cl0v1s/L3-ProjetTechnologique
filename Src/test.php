<?php
/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 20/01/17
 * Time: 19:39
 */

include_once ("Core/Template.php");

$data = array();
$data["name"] = "George";
$data["name1"] = "Vincent";
$data["name2"] = "Cloclo";

$data["false"]  = true;
$data["true"] = false;

$data["people"] = array();
$data["people"][0]["name"] = "Celia";
$data["people"][0]["surname"] = "Paque";
$data["people"][1]["name"] = "Clovis";
$data["people"][1]["surname"] = "Portron";


Template::process("test", $data);