<?php
session_start();
include '../includes/functions.php';

if (isLogged()) {
	header('Location: ../accueil.php');
}

// si clique sur le bouton "Connexion" (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// si un ou plusieurs champs manquants
	if (count(array_filter($_POST)) != count($_POST)) {
    	$error = "Veuillez remplir tous les champs.";
    
    // sinon, tous les champs sont remplis
	} else {

		$pseudo = $_POST['pseudo'];	
		$passwd = $_POST['passwd'];

		// appel de la fonction connectUser située dans ../includes/functions.php ligne 63
		if (connectUser($pseudo, $passwd)) {
				$_SESSION['pseudo'] = $pseudo;
				header('Location: ../accueil.php');
		} else {
			$error = "Le pseudo et le mot de passe sont incorrects.";
		}

	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Trad'INT - Connexion</title>
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
	<h1>ESPACE Connexion</h1>
	<form action="index.php" method="post">
        <table>
            <tr>
                <th colspan="3"><input type="text" name="pseudo" placeholder="Pseudo"/></th>
            </tr>
            <tr>
                <th colspan="3"><input type="password" name="passwd" placeholder="Mot de passe"/></th>
            </tr>
            <tr>
                <th colspan="3"><input type="submit" value="Se connecter"/></th>
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