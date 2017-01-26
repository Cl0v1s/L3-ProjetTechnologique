# Le Modèle

Le modèle de données d'une application consiste en un ensemble de classes et l'utilisation des classes présentes dans Core héritant de Storage (e.g: DatabaseStorage). 

Les classes Storage implémentent chacun les méthodes suivantes: 

* put, place un objet dans la mémoire persistante.
* get, récupère un objet depuis la mémoire persistante. 
* remove, supprime un objet dans la mémoire persistante.
* has, teste si un objet est présent dans la mémoire presistante. 

Les classes du modèle doivent étendre Core/StorageItem et présenter un ensemble d'attributs qui se doivent tous d'être publics.

## DatabaseStorage 
DatabaseStorage permet de manipuler simplement les données de la base de données.

A compléter.

## SessionStorage 

SessionStorage permet de manipuler simplement les données conservées dans les Sessions. 

**exemple d'utilisation stockage de données:**  
```
$storage = Engine::Instance()->Persistence("SessionStorage");

$storage->put(new SessionItem("Logged", true));
```

**exemple d'utilisation récupération de données:**  
```
$storage = Engine::Instance()->Persistence("SessionStorage");
$logged = new SessionItem("logged", NULL);
$logged = $storage->get($logged);
echo $logged->value; // true
```


