<?php
session_start();

// récupère les fonctions PHP
include '../../includes/functions.php';

if (!isLogged()) {
    header('Location: ../../accueil.php');
}

$pseudo    = $_SESSION['pseudo'];
$reference = $_GET['ref'];

// récupère les data de la base de données, d'où le suffixe "db" dans le nom des variables.
list($nomdb, $descriptiondb, $typeAnnoncedb, $typeAnnonceIDdb, $categoriedb, $categorieIDdb, $prixdb, $photo1db, $photo2db, $photo3db) = getDataAnnonce($pseudo, $reference);

// si bouton Annuler clické, alors retour à Mes Annonces
if (isset($_POST['annuler'])) {
    header('Location: index.php');
//si bouton Modifier, alors traitement suivant..
} elseif (isset($_POST['modifier'])) {
    // ne pouvant pas utiliser 'isset', alors vérification du remplissement des champs Titre et Description
    if ($_POST['titre'] != "" && $_POST['description'] != "") {
        
        // récupération des données texte/numérique du formulaire
        $titre       = $_POST['titre'];
        $typeAnnonce = $_POST['typeAnnonce'];
        $categorie   = $_POST['categorie'];
        $description = $_POST['description'];

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

        // si typeAnnonce = Vente, alors le prix doit être strictement supérieur à O
        if ($typeAnnonce == '1') {
            if ($_POST['prix'] > 0) {
                $prix = $_POST['prix'];
                modAnnonce($reference, $titre, $typeAnnonce, $categorie, $description, $prix);
            } else {
                $error = "Prix nul.";
            }
        // si ce n'est pas une vente alors
        } else {
            $prix = "NULL";
            modAnnonce($reference, $titre, $typeAnnonce, $categorie, $description, $prix);
        }

    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Trad'INT - Modifier</title>
	<meta charset="utf-8">
    <script type="text/javascript">
        function changeType(prix) {
            if (document.getElementById('typeAnnonce').value != "1") {
                message = "";
                document.getElementById('prix').innerHTML = message;
            } else {
                message = "<input type=\"number\" name=\"prix\" placeholder=\"Prix\" value=\"" + prix + "\"/> €";
                document.getElementById('prix').innerHTML = message;
            }
        }
    </script>
</head>
<body>
	<ul>
        <li><h2>Trad'INT</h2></li>
        <li><a href="../../accueil.php">Accueil</a></li>
        <li><a href="../../poster/">Poster une annonce</a></li>
        <li><a href="index.php">Mon Compte/Mes Annonces (à mettre dans le menu déroulant)</a></li>
        <li><a href="../parametres/">Mon Compte/Paramètres (à mettre dans le menu déroulant)</a></li>
        <li><a href="../../deconnexion.php">Mon Compte/Se déconnecter (à mettre dans le menu déroulant)</a></li>
	</ul>
	<h1>ESPACE Modification d'annonce</h1>
    <p>Uniquement les champs/photos modifiés seront appliqués à la modification de l'annonce.</p>
	<?php echo '<form action="modify.php?ref='.$reference.'" method="post" enctype="multipart/form-data">'; ?>
        <table>
            <tr>
                <th colspan="3"><?php echo '<input type="text" name="titre" placeholder="Titre" value="'.$nomdb.'"/>'; ?></th>
            </tr>
            <tr>
            	<th colspan="3">
					    <?php
                        echo '<select id="typeAnnonce" name="typeAnnonce" onchange="changeType('.$prixdb.');">';
						showOptionsModify("type_annonce", $typeAnnonceIDdb);
                        echo '</select>';
					    ?>
            	</th>
            </tr>
            <tr>
            	<th colspan="3">
            		<select name="categorie">
					    <?php
						showOptionsModify("categorie", $categorieIDdb);
					    ?>
					</select>
            	</th>
            </tr>
            <tr>
            	<th><textarea name="description" rows="4" cols="50" maxlength="1994" placeholder="Description de l'annonce"><?php echo $descriptiondb; ?></textarea></th>
            </tr>
            <tr>
                <th id="prix">
                    <?php
                    if ($typeAnnoncedb == "Vente") { echo '<input type="number" name="prix" value="'.$prixdb.'"/> €'; }
                    ?>
                </th>
            </tr>

            <!-- DEBUT PHOTO 1 -->
            <tr>
                <th>Photo 1 (obligatoire) :</th>
            </tr>
            <tr>
                <th>
                    <?php
                    echo '<img src="../../src/photos/'.$photo1db.'">';
                    ?>        
                </th>
            </tr>
        	<tr>
        		<th>Changer de photo 1 : <input type="file" name="photo1" accept="image/*"></th>
        	</tr>
            <!-- FIN PHOTO 1 -->

            <!-- DEBUT PHOTO 2 -->
            <tr>
                <th>Photo 2 (facultative) :</th>
            </tr>
            <tr>
                <th>
                    <?php
                    if ($photo2db == NULL) {
                        echo "L'annonce n'a pas de photo 2.";
                    } else {
                        echo '<img src="../../src/photos/'.$photo2db.'">';
                    }
                    ?>
                </th>
            </tr>
        	<tr>
        		<th>
                    <?php
                    if ($photo2db == NULL) {
                        echo "Ajouter une photo 2 : ";
                    } else {
                        echo "Changer la photo 2 : ";
                    }
                    ?> 
                    <input type="file" name="photo2" accept="image/*">
                </th>
        	</tr>
            <tr>
                <th>
                    <?php
                    if ($photo2db != NULL) {
                        echo '<input type="checkbox" name="rmPhoto2"/> Supprimer la photo 2.';
                    }
                    ?>
                </th>
            </tr>
            <!-- FIN PHOTO 2 -->

            <!-- DEBUT PHOTO 3 -->
            <tr>
                <th>Photo 3 (facultative) :</th>
            </tr>
            <tr>
                <th>
                    <?php
                    if ($photo3db == NULL) {
                        echo "L'annonce n'a pas de photo 3.";
                    } else {
                        echo '<img src="../../src/photos/'.$photo3db.'">';
                    }
                    ?>
                </th>
            </tr>
            <tr>
                <th>
                    <?php
                    if ($photo3db == NULL) {
                        echo "Ajouter une photo 3 : ";
                    } else {
                        echo "Changer la photo 3 : ";
                    }
                    ?> 
                    <input type="file" name="photo3" accept="image/*">
                </th>
            </tr>
            <tr>
                <th>
                    <?php
                    if ($photo3db != NULL) {
                        echo '<input type="checkbox" name="rmPhoto3"/> Supprimer la photo 3.';
                    }
                    ?>
                </th>
            </tr>
            <!-- FIN PHOTO 3 -->

            <tr>
                <th colspan="3">
                    <input type="submit" name="modifier" value="Modifier l'annonce"/>
                    <input type="submit" name="annuler" value="Annuler"/>
                    <!--<button type="button" name="annuler" onClick="window.location='index.php';">Annuler</button>-->
                </th>
            </tr>
            <tr>
                <th colspan="3" id="error">
                    <?php
                    if (isset($error)) { echo $error; }
                    ?>
                </th>
            </tr>
        </table>
    </form>
</body>
</html>