README.md à compléter ! Merci :)

# Trad'INT

Dans le cadre du module de base de données : projet Leboncoin-like pour le campus TMSP.

URL du site : [https://tradint.dantran.fr](https://tradint.dantran.fr)

Wiki / Guide : [https://github.com/MrDanao/tradint/wiki/Documentation](https://github.com/MrDanao/tradint/wiki/Documentation)

## Sommaire

- [Sommaire](https://github.com/MrDanao/tradint#sommaire)
- [To-Do List](https://github.com/MrDanao/tradint#to-do-list)
- [Environnement](https://github.com/MrDanao/tradint#environnement)
  - [Paquets installés](https://github.com/MrDanao/tradint#paquets-install%C3%A9s)
  - [MySQL](https://github.com/MrDanao/tradint#mysql)
  - [PhpMyAdmin](https://github.com/MrDanao/tradint#phpmyadmin)
- [Remarques sur le site et son code](https://github.com/MrDanao/tradint#remarques-sur-le-site-et-son-code)
   - [Fichier includes/functions.php](https://github.com/MrDanao/tradint#fichier-includesfunctionsphp)
   - [Page d'Inscription](https://github.com/MrDanao/tradint#page-dinscription)

## To-Do List

>:heavy_check_mark: = done.   
>:clock8: = soon.

- Inscription :   
:heavy_check_mark: Formulaire HTML.   
:heavy_check_mark: Vérification du remplissement du formulaire.   
:heavy_check_mark: Vérification de l'inexistance d'un utilisateur.   
:heavy_check_mark: Stockage de mot de passe protégé (hash & salt).   
:heavy_check_mark: Ajout global d'un user dans la database.   
:clock8: Vérification des chaînes de caractères avant l'envoi ou après au serveur.   
:heavy_check_mark: Style CSS.

- Connexion :   
:heavy_check_mark: Formulaire HTML.   
:heavy_check_mark: Vérification du remplissement du formulaire.   
:heavy_check_mark: Vérification de l'existance d'un utilisateur.   
:heavy_check_mark: Vérification du mot de passe.   
:heavy_check_mark: Style CSS.

- Ajout d'annonce :   
:heavy_check_mark: Formulaire HTML.   
:heavy_check_mark: Vérification du remplissement du formulaire.        
:heavy_check_mark: Ajout global d'une annonce dans la database.   
:clock8: Vérification des chaînes de caractères avant ou après l'envoi au serveur.   
:heavy_check_mark: Style CSS.

- Accueil :   
:heavy_check_mark: Listing des annonces.   
:heavy_check_mark: Lien de redirection vers chaque annonce.   
:heavy_check_mark: Système de page.   
:heavy_check_mark: Visuel de la barre des numéros de page.   
:heavy_check_mark: Style CSS.

- Page dédiée à une annonce :   
:heavy_check_mark: Affichage de l'annonce.   
:heavy_check_mark: Affichage des coordonnées de contact du vendeur, si l'utilisateur est connectée.   
:heavy_check_mark: Style CSS.

- Moteur de recherche d'annonce :   
:heavy_check_mark: Formulaire HTML.   
:heavy_check_mark: Recherche avec critères (nom, catégorie, type d'annonce, localisation).   
:heavy_check_mark: Style CSS.

- Gestion du compte utilisateur :   
:heavy_check_mark: Gestionnaire d'annonce (modification et suppression).   
:heavy_check_mark: Modification de la localisation de l'utilisateur.   
:heavy_check_mark: Modification du mot de passe.   
:heavy_check_mark: Suppression du compte.   
:heavy_check_mark: Style CSS.

- Final :   
:heavy_check_mark: Review générale du code. 

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
> grant all privileges on *.* to 'admin'@'localhost';
> flush privileges;
```

### PhpMyAdmin

```
echo "Include /etc/phpmyadmin/apache.conf" >> /etc/apache2/apache2.conf
```

Aller sur : `http://adresse_ip/phpmyadmin`

Dans ce dépôt git se trouve le fichier `bdd.sql` qui décrit en SQL la base de données et ses tables.

1) Créer la base de données `tradint` dans phpmyadmin.
2) Dans la base `tradint`, importer le fichier `backup_database_for_phpmyadmin.sql`.

Note : quelques catégories, types d'annonce et localisations sont créés.

## Remarques sur le site et son code
### Fichier `includes/functions.php`

Ce fichier contient des fonctions php communes au site.

Les credentials (user, passwd) n'étant pas présents dans la fonction `connectDB()` pour se connecter à la base de données, il faut donc écrire vos propres credentials correspondant à votre environnement de développement.

### Page d'Inscription

~~Il faut remplir tous les champs à la main et ne pas utiliser les suggestions du navigateur Web.~~
