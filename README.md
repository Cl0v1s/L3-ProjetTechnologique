# L3 - Projet Technologique 

## La demande 

### Les besoins de la commune

Mise en ligne d’une base de données recensant l’ensemble des services pour les séniors et les personnes handicapées:
* aides à domicile,
* soins infirmiers,
* loisirs,

Reliée au site internet de la ville, cette base de données permettrait de visualiser les services disponibles en les géo localisant.

* Créer un espace où les personnes âgées ou leurs familles pourraient poser leurs questions.
* Créer un espace pour rassembler les propositions des habitants de la commune qui souhaiteraient s’investir dans le bénévolat et notamment aider les plus âgées via des visites de courtoisie, de l’aide aux petits travaux, de l’aides aux transports, etc.

#### Les objectifs

Créer une base d’informations accessible et intuitive permettant aux personnes les moins à l’aise avec l’outil informatique de trouver une réponse à leurs questions.
Créer un outil pour les agents du service leur permettant de répertorier l’offre à destination de ce public et de suivre son évolution dans la commune.

Reste à traduire ceci en services. Cela peut faire partie du projet.

Voici comment j’imagine les choses:

Décrire les pages accessibles, comment elles s’organisent (classes PHP ?), quelle est la bdd associée:
   * Publique Services disponibles
   * Admin Services disponibles
   * Publique Questions aux agents
   * Admin Questions aux agents
   * Publique Propositions (modéré)
   * Admin Propositions

#### Quelques questions
* comment identifier la personne qui envoie une question ou une proposition
* comment géolocaliser le client pour filtrer les services et/ou décrire le lieu des manifestations
* comment se prémunir contre les attaques de service, les usagers mal intentionnés



## Description

Ce repo contient le code réalisé dans le cadre du Projet Technologique prodigué en Licence 3 informatique à l'Université de Bordeaux.


## Fonctionnalités 

* Créer une bête liste de services disponibles classés par catégories (loisir, aides à domicile, loisir)


* Créer un espace permettant aux aministrés de poser leurs questions.
	* étudier moteur de recherche versus liste exhaustive  
	* Pour poser une question nécessaire d'effectuer une recherche auparavant (éviter redondance)
	* --On affiche que les questions possédant une réponse (administration indirecte)--
	* On affiche toutes les questions, en priorité celles sans réponse afin de permettre aux concitoyens.
	* Regrouper par topic
	* Page d'accueil affichant les questions les plus consultées. 


* Administration 
	* Gestion des questions 
	* Gestions des comptes utilisateurs 
	* Gestions des services (Ajout de lien dans les menus)

## TODO

* Rédiger un cahier des charges professionnel 


## Workflow

* Utilisation de GitFlow
* 


## Remarques

 
