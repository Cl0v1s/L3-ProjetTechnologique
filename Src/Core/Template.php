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
        $matches = array();

        // recherche et concaténation des includes
        preg_match_all("<#(.*?)#>", $content, $matches);
        foreach($matches[1] as $match)
        {
            $key = str_replace(" ", "", $match);
            $content = preg_replace("(<#".$match."#>)", Template::prepare($key, $data), $content, 1);
        }

        // recherche et expansion des boucles
        preg_match_all("<%(.*?)%>(.*?)</%>", $content, $matches);
        for($i = 0; $i != count($matches[1]); $i++)
        {
            $ma = array();
            $match = $matches[1][$i];
            $inside = $matches[2][$i];
            preg_match_all("<=(.*?)=>", $inside, $ma);
            foreach($ma[1] as $mat)
            {
                $key = str_replace(" ", "", $mat);
                $content = preg_replace("(<=".$mat."=>)", $data[$key], $content, 1);
            }
        }

        // recherche et remplacement des données
        //recherche des variables
        preg_match_all("<=(.*?)=>", $content, $matches);
        foreach($matches[1] as $match)
        {
            $key = str_replace(" ", "", $match);
            $content = preg_replace("(<=".$match."=>)", $data[$key], $content, 1);
        }

        echo $content;
        return $content;
    }
}