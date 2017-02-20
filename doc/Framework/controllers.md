# Les contrôleurs

Les contrôleurs permettent de gérer les demandes et les actions des utilisateurs en faisant le lien entre leurs demandes, le modèle et les vues. 

Les contôleurs doivent hériter de Core/Controller et être placés dans le répertoire Controllers situé à la racine des fichiers de l'application web.

La méthode run doit être implémentée. Elle sera appelée par le système en fonction des demandes des utilisateurs. 

## Exemple de contrôleur

```
<?php

include_once "Core/Controller.php";

class DefaultController extends Controller
{

    function __construct($params)
    {
       parent::__construct($params);
    }

    public function run($ctx)
    {
        $view = new View("index");
        $view->setTitle("Index");
        $view->show();
    }
}
```

Présente la vue "index", avec le titre "Index", lorsque l'utilisateur souhaite accéder à http://url.com/Default .