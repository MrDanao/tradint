<?php
session_start();

// récupère les fonctions PHP
include '../../includes/functions.php';

if (!isLogged()) {
    header('Location: ../../accueil.php');
}

$pseudo    = $_SESSION['pseudo'];
$reference = $_GET['ref'];

list($nom, $description, $typeAnnonce, $categorie, $prix, $photo1, $photo2, $photo3) = getDataAnnonce($pseudo, $reference);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Trad'INT - Modifier</title>
	<meta charset="utf-8">
</head>
<body>
	<ul>
		<li><h2>Trad'INT</h2></li>
		<li><a href="../../accueil.php">Accueil</a></li>
		<li><a href="../../poster/">Poster une annonce</a></li>
		<li><a href="../../compte/">Mon compte</a></li>
		<li><a href="../../deconnexion.php">Se déconnecter</a></li>
	</ul>
	<h1>ESPACE Modification d'annonce</h1>	
	<form action="index.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <th colspan="3"><?php echo '<input type="text" name="titre" value="'.$nom.'"/>'; ?></th>
            </tr>
            <tr>
            	<th colspan="3">
            		<select id="typeAnnonce" name="typeAnnonce" onchange="changeType();">
					    <?php
						showOptions("type_annonce");
					    ?>
					</select>
            	</th>
            </tr>
            <tr>
            	<th colspan="3">
            		<select name="categorie">
					    <?php
						showOptions("categorie");
					    ?>
					</select>
            	</th>
            </tr>
            <tr>
            	<th><textarea name="description" rows="4" cols="50" maxlength="1994" placeholder="Description de l'annonce"></textarea></th>
            </tr>
        	<tr>
        		<th id="prix"></th>
        	</tr>
        	<tr>
        		<th>Photo 1 (obligatoire)<input type="file" name="photo1" accept="image/*"></th>
        	</tr>
        	<tr>
        		<th>Photo 2 (facultative)<input type="file" name="photo2" accept="image/*"></th>
        	</tr>
        	<tr>
        		<th>Photo 3 (facultative)<input type="file" name="photo3" accept="image/*"></th>
        	</tr>
            <tr>
                <th colspan="3"><input type="submit" value="Ajouter l'annonce"/></th>
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