<?php
session_start();
include '../includes/functions.php';

if (!isLogged()) {
	header('Location: ../connexion/');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['categorie']) && isset($_POST['typeAnnonce']) && !empty($_FILES['photo1']['tmp_name'])) {

		$utilisateur = $_SESSION['pseudo'];
		$titre 		 = $_POST['titre'];
		$typeAnnonce = $_POST['typeAnnonce'];
		$categorie   = $_POST['categorie'];
		$description = $_POST['description'];
		$photo1      = $_FILES['photo1'];
		$photo2      = isFileUp($_FILES['photo2']);
		$photo3      = isFileUp($_FILES['photo3']);

		if ($typeAnnonce == '1') {
			if ($_POST['prix'] > 0) {
				$prix = $_POST['prix'];
				addAnnonce($utilisateur, $titre, $typeAnnonce, $categorie, $description, $prix, $photo1, $photo2, $photo3);
			} else {
				echo "KO";
			}
		} else {
			$prix = "NULL";
			addAnnonce($utilisateur, $titre, $typeAnnonce, $categorie, $description, $prix, $photo1, $photo2, $photo3);
		}
	} else {
		echo "KO";
	}

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Trad'INT - Poster une annonce</title>
	<meta charset="utf-8">
	<script type="text/javascript">
		function changeType() {
			if (document.getElementById('typeAnnonce').value != "1") {
				message = "";
				document.getElementById('prix').innerHTML = message;
            } else {
            	message = "<input type=\"number\" name=\"prix\" placeholder=\"Prix\"/>";
				document.getElementById('prix').innerHTML = message;
            }
		}
	</script>
</head>
<body>
	<ul>
		<li><h2>Trad'INT</h2></li>
		<li><a href="../accueil.php">Accueil</a></li>
		<li><a href="../poster/">Poster une annonce</a></li>
		<li><a href="../compte/">Mon compte</a></li>
		<li><a href="../deconnexion.php">Se déconnecter</a></li>
	</ul>
	<h1>ESPACE Poster une annonce</h1>
	
	<form action="index.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <th colspan="3"><input type="text" name="titre" placeholder="Titre de l'annonce"/></th>
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