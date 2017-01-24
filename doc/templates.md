# Le système de templates

Afinde faciliter le développement front-end du site, un système de template a été produit.  
Il consiste en un ensemble de balises supplémentaires, à utiliser en supplément d'HTML et permettant de rendre ce dernier "intelligent". On distingue entre autre, la possibilité d'afficher des variables, d'itérer sur des tableaux et d'afficher du code html de manière conditionnelle. 

## Balises 


| Balise | Effet |
|------|----|
| {{data}} | Est remplacé par le contenu de la variable `data` |
| {{=data}} html {{/data}} | html est affiché seulement si le contenu de la variable `data` est vrai. |
| {{#array}} html {{data1}} html {{data2} html {{/array}} | Itère dans le tableau de tableau  `array` et affiche `html ... html` autant de fois qu'il y a d'entrées dans `array`. Si `data1` et `data2` sont des entrées de tableaux contenus dans `array` leurs valeurs seront affichées` |

