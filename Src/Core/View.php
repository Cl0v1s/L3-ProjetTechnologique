<?php

include_once 'Core/Template.php';

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 24/01/17
 * Time: 17:32
 */
class View
{
    private $data;
    private $template;

    function __construct($template, $data = NULL)
    {
        if($data == NULL)
            $this->data = array();
        else
            $this->data = $data;

        $this->template = $template;
    }

    /**
     * Change le titre de la vue
     * @param $title titre de la page
     */
    public function setTitle($title)
    {
        $this->setData("__title", $title);
    }

    /**
     * Change une valeur des données transmises à la vue
     * @param $key nom de la valeur
     * @param $value valeur
     */
    public function setData($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Retourne une valeur contenue dans les données transmises au template
     * @param $key clef de la donnée à récupérer
     * @return mixed valeur de la donné récupérer
     * @throws Exception L'entrée $key n'est pas fixée.
     */
    public function getData($key)
    {
        if(!isset($this->data[$key]))
            throw new Exception("The entry ".$key." is not set.");
        return $this->data[$key];
    }

    /**
     * Affiche la vue
     */
    public function show()
    {
        Template::process($this->template, $this->data);
    }
}