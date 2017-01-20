<?php

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 20/01/17
 * Time: 19:29
 */
class Template
{
    /**
     * Lit un fichier tempmlate et produit du code html en fonction de $data
     * @param $file
     * @param $data
     */
    public static function prepare($file, $data)
    {
        $content = file_get_contents("Templates/".$file);


        // recherche et remplacement des données
        $matches = array();
        //recherche des variables
        preg_match_all("<%(.*?)%>", $content, $matches);
        echo count($matches);
        foreach($matches as $match)
        {
            echo $match[0];
        }
    }
}