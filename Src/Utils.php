<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 31/03/17
 * Time: 15:09
 */
class Utils
{
    public static function SessionVariables()
    {
        if(isset($_SESSION["Admin"])){
            $data["admin"] = true;
            $data["user"] = false;
        }else{
            $data["admin"] = false;
            $data["user"] = true;
        }
        if(isset($_SESSION["User"])){
            $data["connected"] = true;
            $data["disconnected"] = false;
        }else{
            $data["disconnected"] = true;
            $data["connected"] = false;
        }
        return $data;
    }

    public static function MakeTextSafe($text)
    {
        $text = str_replace("'", "\\'", $text);
        $text = str_replace("\"", "\\\"", $text);
        $text = str_replace("<", "&lt;", $text);
        $text = str_replace(">", "&gt;", $text);
        return $text;
    }
}