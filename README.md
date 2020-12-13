# Projet blog avec Symfony

## *Djellal Ahmed Abderrahmane*

### Description

Ce Projet consiste a realiser un blog personnel qui affiche une liste d'articles paginé, ce blog donne l'option a un admin connecter de supprimer, modifier ou ajouter d'autre articles.

Le déploiyment de ce projet et effectuer sur ***Heroku*** et le lien d'acces est https://still-garden-73069.herokuapp.com/

### Admin panel

**compte/username** : demo

**mot de passe** : demo

### Commentaires

- les données des articles sont generes automatiquement par la bibliotheque faker de php et en lancant les fixtures dans l'environement de développement.

- l'utilisation de deux facon de generation des slugs, soit avec la bibliotheque ***Cocur\Slugify*** , soit avec bundle ***StofDoctrineExtensionsBundle*** en utilisant les @ notations.

- le projet contient deux versions, une version qui utilise une base de données mysql et une autre qui utilise postgresql ( car l'addons le gratuit de bdd dans heroku utilise postgresql), la branche ***postgresVariant*** contient la variante avec une connection postgres.

- Pour l'api REST, utilisation de la bibliotheque ***Hateoas***, pour pouvoir ajouter les niveaux de maturation de Richardson ( plus precisement, l'ajout des ***Hypermedia Controls*** )

  