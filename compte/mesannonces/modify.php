<?php
session_start();

// récupère les fonctions PHP
include '../../includes/functions.php';

if (!isLogged()) {
    header('Location: ../../accueil.php');
}

$pseudo    = $_SESSION['pseudo'];

// récupère les data de la base de données, d'où le suffixe "db" dans le nom des variables.
//

if (isset($_POST['ref'])) {
    $titre       = isset($_POST['titre'])?$_POST['titre']:NULL;
    $typeAnnonce = isset($_POST['typeAnnonce'])?$_POST['typeAnnonce']:NULL;
    $categorie   = isset($_POST['categorie'])?$_POST['categorie']:NULL;
    $description = isset($_POST['description'])?$_POST['description']:NULL;
    $prix = isset($_POST['prix'])?$_POST['prix']:NULL;
    $reference = $_POST['ref'];

    list($nomdb, $descriptiondb, $typeAnnoncedb, $typeAnnonceIDdb, $categoriedb, $categorieIDdb, $prixdb, $photo1db, $photo2db, $photo3db) = getDataAnnonce($pseudo, $reference);
    // si une photo1 est uploadée => suppresion de l'ancienne photo, upload de la nouvelle photo et mise à jour de la db
        if (isFileUp($_FILES['photo1']) != "NULL") {
            $photo1 = $_FILES['photo1'];
            $photoToDelete = $photo1db;
            modPhoto($reference, $photo1, $photoToDelete, 1);
        }

        // gestion de la photo 2
        // si l'annonce n'a pas de photo2 par défaut
        if ($photo2db == NULL) {
            // si une photo est uploadé => upload de la nouvelle photo dans le serveur et mise à jour de la db
            if (isFileUp($_FILES['photo2']) != "NULL") {
                $photo2 = $_FILES['photo2'];
                UploadInsertPhoto($photo2, $reference, 2, "../");
            }
        // si l'annonce à déjà une photo 2
        } else {
            // si une nouvelle photo2 est uploadée => suppresion de l'ancienne photo, upload de la nouvelle photo et mise à jour de la db
            if (isFileUp($_FILES['photo2']) != "NULL") {
                $photo2 = $_FILES['photo2'];
                $photoToDelete = $photo2db;
                modPhoto($reference, $photo2, $photoToDelete, 2);
            }
            // si la case Supprimer est cochée => suppresion de la photo du serveur et mise à jour de la db
            if (isset($_POST['rmPhoto2'])) {
                rmPhoto($reference, $photo2db, 2);
            }
        }

        // gestion de la photo 3
        // si l'annonce n'a pas de photo3 par défaut
        if ($photo3db == NULL) {
            // si une photo est uploadé => upload de la nouvelle photo dans le serveur et mise à jour de la db
            if (isFileUp($_FILES['photo3']) != "NULL") {
                $photo3 = $_FILES['photo3'];
                UploadInsertPhoto($photo3, $reference, 3, "../");
            }
        // si l'annonce à déjà une photo 3
        } else {
            // si une nouvelle photo3 est uploadée => suppresion de l'ancienne photo, upload de la nouvelle photo et mise à jour de la db
            if (isFileUp($_FILES['photo3']) != "NULL") {
                $photo3 = $_FILES['photo3'];
                $photoToDelete = $photo3db;
                modPhoto($reference, $photo3, $photoToDelete, 3);
            }
            // si la case Supprimer est cochée => suppresion de la photo du serveur et mise à jour de la db
            if (isset($_POST['rmPhoto3'])) {
                rmPhoto($reference, $photo3db, 3);
            }
        }
    
    // ne pouvant pas utiliser 'isset', alors vérification du remplissement des champs Titre et Description
    if(empty($titre) && empty($typeAnnonce) && empty($categorie) && empty($description) && empty($prix)){
         echo "Aucune modification";
         header('Location: index.php');
    }else {
        if (!empty($titre)){
            
            modAnnonce($reference, $titre, 1);
        }
        
        if (!empty($typeAnnonce)) {

            modAnnonce($reference, $typeAnnonce, 2);

        }

        if (!empty($categorie)) {

            modAnnonce($reference, $categorie, 3);

        }

        if (!empty($description)) {

            modAnnonce($reference, $description, 4);

        }
        
        if (!empty($prix)) {

            modAnnonce($reference, $prix, 5);

        }
    
        //$error = "Veuillez remplir tous les champs.";
       
    }

      
}

?>