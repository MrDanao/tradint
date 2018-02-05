README.md à compléter ! Merci :)

# Trad'INT

Dans le cadre du module de base de données : projet Leboncoin-like pour le campus TMSP.

## Environnement

### Paquets installés

```
apt install apache2 libapache2-mod-php mysql-client mysql-server phpmyadmin
```

### MySQL

Pour mot de passe root mysql :

```
sudo mysql_secure_installation
```

Création d'un utilisateur administrateur pour phpmyadmin et les requêtes :

```
mysql -u root -p
> create user 'admin'@'localhost' identified by 'votre_mot_de_passe';
> grant all privileges *.* to 'admin'@'localhost';
> flush privileges;
```

### PhpMyAdmin

Aller sur : `http://adresse_ip/phpmyadmin`

Dans ce dépôt git se trouve le fichier `bdd.sql` qui décrit en SQL la base de données et ses tables.

1) Créer la base de données `tradint` dans phpmyadmin.
2) Dans la base `tradint`, importer le fichier `bdd.sql`.

Note : quelques catégories, types d'annonce et localisations sont créés.

## Le site et son code
### Fichier `includes/functions.php`

Ce fichier contient des fonctions php communes au site.

Les credentials (user, passwd) n'étant pas présents dans la fonction `connectDB()` pour se connecter à la base de données, il faut donc écrire vos propres credentials correspondant à votre environnement de développement.

### Page d'Inscription

Il faut remplir tous les champs à la main et ne pas utiliser les suggestions du navigateur Web.

## To-Do List

* Inscription : done
* Connexion : done
* Ajout d'annonce : presque done, manque v�rification du formulaire
* Listing des annonces dans la page d'accueil avec pagination : done
* Gestion de l'utilisateur (mdp, annonces, suppression compte, etc)
