# Le système de templates

Afinde faciliter le développement front-end du site, un système de template a été produit.  
Il consiste en un ensemble de balises supplémentaires, à utiliser en supplément d'HTML et permettant de rendre ce dernier "intelligent". On distingue entre autre, la possibilité d'afficher des variables, d'itérer sur des tableaux et d'afficher du code html de manière conditionnelle. 

## Balises 


| Balise | Effet |
|------|----|
| {{@template}} | Permet d'inclure le template `template` dans la présentation courante |
| {{data}} | Est remplacé par le contenu de la variable `data` |
| {{=data}} html {{/data}} | html est affiché seulement si le contenu de la variable `data` est `true`. |
| {{#array}} html {{data1}} html {{data2} html {{/array}} | Itère dans le tableau de tableau  `array` et affiche `html ... html` autant de fois qu'il y a d'entrées dans `array`. Si `data1` et `data2` sont des entrées de tableaux contenus dans `array` leurs valeurs seront affichées` |

## Exemple de template 

header.html
```
<html>
	<head>
    	<title>{{__title}}</title>
    </head>
    <body>
```

footer.html
```
	</body>
</html>
```

template.html
```
{{@header}}
	{{=connected}}
        <div class='user-connected'>
            Connecté en tant que {{username}}.
        </div>
    {{/connected}}
    {{=disconnected}}
    	<div class='connection'>
        	Se connecter
        </div>
    {{/disconnected}}
	Bonjour et bienvenue sur notre site !<br>
    Liste des fonctions:</br>
    <table>
    	<tr>
        	<td>Nom</td><td>Description</td>
        </tr>
        {{#functions}}
        <tr>
        	<td>{{name}}</td><td>{{description}}</td>
        </tr>
        {{/functions}}
	</table>
{{@footer}}
```

Avec les données:

| nom | valeur |
|--|--|
| connected | true |
| disconnected | false |
| functions | array(array("name"=>"direBonjour", "description" => "Dit bonjour"), array("name"=>"direAurevoir", "description" => "Dit au revoir")) |
| username | Dupont |

Affichera une page bien ordonnée.



    