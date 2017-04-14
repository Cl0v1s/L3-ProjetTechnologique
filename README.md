# L3 - Projet Technologique 
 
## Configuration requise du serveur 

* Serveur HTTP Apache2
	* mod_php
	* mod_rewrite
	* configuration permettant la priorité des fichier .htaccess sur la configuration générale.

* PHP5
* Serveur MySQL
* PHPMyAdmin (pour administrer Mysql)

## Installation et configuration de la plateforme sur le serveur 

* Copier-coller le contenu du répertoire Src (./Src) à la racine du site web sur le serveur 
* Exécuter le script sql trouvable à ./sql/Disabled.sql sur le serveur Mysql 
* Modifier la ligne suivante dans le fichier index.php à la racine du site web sur le serveur
    Engine::Instance()->setPersistence(new DatabaseStorage("localhost", "Disabled", "root", "root"));
En remplacant localhost par l'adresse à laquelle est accessible votre serveur mysql, et root, root par respectivement un nom d'utilisateur Mysql et son mot de passe disposant des droits d'écriture et de lecture sur la base Disabled crée précédemment à l'aide du script. 
* Une fois la plateforme en ligne, vous pouvez vous connecter à l'aide de l'utilisateur root.root (mot de passe: root). Utilisez le pour créer un nouvel utilisateur avec les droits d'admin et supprimez le. 
