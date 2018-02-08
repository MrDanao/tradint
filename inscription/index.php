<?php

include '../includes/functions.php';

if (isLogged()) {
	header('Location: ../accueil.php');
}

// si clique sur le bouton "Créer mon compte" (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// si un ou plusieurs champs manquants
	if ((count(array_filter($_POST)) != count($_POST)) || (!isset($_POST['localisation']))) {
    	$error = "Veuillez remplir tous les champs.";
    
    // sinon, tous les champs sont remplis
	} else {

		$pseudo		   = $_POST['pseudo'];
		$email		   = $_POST['email'];
		$phone		   = $_POST['phone'];
		$localisation  = $_POST['localisation'];	
		$passwd 	   = $_POST['passwd'];
		$passwdconfirm = $_POST['passwdconfirm'];

		if ($passwd == $passwdconfirm) {

			// Vérifie si le pseudo renseigné est inexistant
			// fonction checkUserInexistance dans fichier ../includes/functions.php ligne 19
			if (checkUserInexistance($pseudo)) {
				// si true alors création du user dans la base de données
				// fonction insertUserDB dans le fichier ../includes/functions.php ligne 46
				if (insertUserDB($pseudo, $email, $phone, $localisation, $passwd)) {
					$error = "Votre compte a bien été créé.</br>Vous serez redirigé vers la page de connexion dans quelques instants";
					header('Location: ../connexion/');
				} else {
					$error = "Votre compte n'a pas été créé.";
				}
			} else {
				$error = "Ce pseudo n'est plus disponible.";
			}

		} else {
			$error = "Les mots de passes ne correspondent pas.";
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Trad'INT - Inscription</title>
	<meta charset="utf-8">
</head>
<body>
	<ul>
		<li><h2>Trad'INT</h2></li>
		<li><a href="../accueil.php">Accueil</a></li>
		<li><a href="../poster/">Poster une annonce</a></li>
		<li><a href="../inscription/">Inscription</a></li>
		<li><a href="../connexion/">Connexion</a></li>
	</ul>
	<h1>ESPACE Inscription</h1>
	<form action="index.php" method="post">
        <table>
            <tr>
                <th colspan="3"><input type="text" name="pseudo" placeholder="Pseudo"/></th>
            </tr>
            <tr>
                <th colspan="3"><input type="email" name="email" placeholder="Email"/></th>
            </tr>
            <tr>
                <th colspan="3"><input type="tel" name="phone" placeholder="Numéro de téléphone"/></th>
            </tr>
            <tr>
            	<!-- 
            		ci-dessous, listing des locations STATIC
					A FAIRE : listing dynamique avec php et la base de données (table localisation)
            	 -->
            	<th colspan="3">
            		<select name="localisation">
						<?php
						showOptions("localisation");
					    ?>
					</select>
            	</th>
            </tr>
            <tr>
                <th colspan="3"><input type="password" name="passwd" placeholder="Mot de passe"/></th>
            </tr>
            <tr>
                <th colspan="3"><input type="password" name="passwdconfirm" placeholder="Confirmer le mot de passe"/></th>
            </tr>
            <tr>
                <th colspan="3"><input type="submit" value="Créer mon compte"/></th>
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