#**Rapport de réalisation - Projet technologique**

###**Avant-propos :**

Ce document vise à fournir une description exhaustive du projet mené dans le cadre de l'UE Projet technologique de la L3 de l'université de Bordeaux.
La mairie de Pessac joue ici le rôle du client, en ayant exprimé son besoin d'une plate forme d'information, fournissant ainsi son cadre au projet.

###**Cahier des charges :**

####Présentation générale du besoin et objectifs :

La mairie de Pessac souhaite disposer d’une plateforme en ligne accessible et intuitive permettant aux personnes les moins à l’aise avec l’outil informatique de trouver une réponse à leurs questions en lien avec la vie communautaire.
De plus, il sera nécessaire de créer un outil pour les agents du service leur permettant de répertorier l’offre à destination de ce public et de suivre son évolution dans la commune.
Dans l’esprit du client, il s’agit de mettre en place une base de données recensant l’ensemble des services pour les seniors et les personnes handicapées tels que l’aide à domicile, des soins infirmiers, des loisirs etc.
De plus, étant donné les objectifs précédemment présentés, cette plateforme se destine à être utilisée par un public n’étant pas spécialement habitué aux nouvelles technologies et aux pratiques qui leurs sont associées, ou alors, ne disposant pas de la totalité de ses possibilités de perception et d’action.
Un soin tout particulier devra donc être porté à l’ergonomie de l’interface. E.g : Toute icône devra être légendée, étant donné que sa signification pourrait ne pas être évidente pour un non-initié.
Reliée au site internet de la ville, cette base de données permettrait de visualiser les services disponibles en les géolocalisant.

Dans les grandes ligne, il faudrait : 
Créer un espace répertoriant les services disponibles.
Créer un espace où les personnes âgées ou leurs familles pourraient poser leurs questions.
Créer un espace pour rassembler les propositions des habitants de la commune qui souhaiteraient s’investir dans le bénévolat et notamment aider les plus âgées via des visites de courtoisie, de l’aide aux petits travaux, de l’aides aux transports, etc. 

####Présentation et analyse de l'existant :

La mairie de Pessac dispose d’un site Internet dynamique regroupant un certain nombre d’informations. 
On estime donc qu’elle dispose d’un système d’hébergement permettant l’usage d’une base de données. 
Étant donné le manque d’informations, on estimeras que le site internet existant n’est pas extensible. Nous construirons donc notre système de manière à ce qu’il soit autonome, dans le sens où il disposera de sa propre base de données, et ne viendra pas se greffer directement au code existant. 
Le lien entre la plateforme que nous allons réaliser et le site existant demandé se réalisera donc à travers un simple un lien hypertexte permettant de passer du site de la mairie à notre système, de façon à ce que cette transition soit transparente pour l’utilisateur. 

###**Analyse fonctionnelle :**

La plateforme présente trois parties :

- Une liste de services disponibles classées par catégories (loisir, aide à domicile ...)
- Un espace dédié aux questions des utilisateurs :
	- possibilité de recherche de question
	- possibilité de répondre aux questions
	- possibilité de poser une question (nécessite d'être connecté)
	- regroupement des questions par sujets
- Une partie d'administration :
	- gestion des questions
	- gestion des comptes utilisateurs
	- gestion des services 

###**Analyse technique :**



###**Retour d'expérience :**

