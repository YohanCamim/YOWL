## Présentation du projet

Ce projet permet de noter les différents articles liés à l'actualité des jeux-vidéos en utilisant Laravel et VueJS

## Technologies Utilisées

### Partie VueJS

Utilisation de VueJS 3 avec VueX afin de gérer les requêtes et reponses API, ainsi que Vue Router afin d'avoir un site web dynamique

### Partie Laravel

Utilisation de Breeze pour l'authentifiation et l'inscription, Laravel permet de créer une API facilement

## Installation

### Partie VueJS 

Installer les dépendances dans la partie VueJS

`npm install`

#### Utilisation

Lancer le serveur VueJS

`npm run serve`

### Partie Laravel

-Installer les dépendances de composer et de npm (Breeze)

```
composer install
npm install
npm run dev
```

-Modifier fichier .env.example avec ses informations de BDD et l'enregister en .env

-Lancer les migrations

`php artisan migrate:fresh`

-Lancer les seeds si l'on souhaite des fausses données

`php artisan db:seed`

#### Utilisation

Lancer le serveur Laravel

`php artisan serve`