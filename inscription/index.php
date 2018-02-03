<?php

include '../includes/functions.php';

if (isLogged()) {
	header('Location: ../annonces');
}

// si clique sur le bouton "Créer mon compte" (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// si un ou plusieurs champs manquants
	if ((count(array_filter($_POST)) != count($_POST)) || ($_POST['localisation'] == 'none')) {
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
					$error = "Votre compte a bien été créé.</br>Vous serez redirigé vers la page de connexion dans 3 secondes...";
					sleep(3);
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
</head>
<body>
	<ul>
		<li><h2>Trad'INT</h2></li>
		<li>Accueil</li>
		<li>Poster une annonce</li>
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
                <th colspan="3"><input type="text" name="email" placeholder="Email"/></th>
            </tr>
            <tr>
                <th colspan="3"><input type="text" name="phone" placeholder="Numéro de téléphone"/></th>
            </tr>
            <tr>
            	<!-- 
            		ci-dessous, listing des locations STATIC
					A FAIRE : listing dynamique avec php et la base de données (table localisation)
            	 -->
            	<th colspan="3">
            		<select name="localisation">
					    <option value="none">Votre localisation</option>
					    <option value="1">Bâtiment U1</option>
					    <option value="2">Bâtiment U2</option>
					    <option value="3">Bâtiment U3</option>
					    <option value="4">Bâtiment U4</option>
					    <option value="5">Bâtiment U5</option>
					    <option value="6">Bâtiment U6</option>
					    <option value="7">Bâtiment U7</option>
					    <option value="8">Externe</option>
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