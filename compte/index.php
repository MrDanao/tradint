<?php
session_start();
include '../includes/functions.php';

if (!isLogged()) {
	header('Location: ../annonces/');
}

// à compléter

?>
<!DOCTYPE html>
<html>
<head>
	<title>Trad'INT - Compte</title>
</head>
<body>
	<ul>
		<li><h2>Trad'INT</h2></li>
		<li><a href="../annonces/">Accueil</a></li>
		<li><a href="../poster/">Poster une annonce</a></li>
		<li><a href="../compte/">Mon compte</a></li>
		<li><a href="../deconnexion.php">Se déconnecter</a></li>
	</ul>
	<h1>ESPACE Compte</h1>

	<!--
		Ecrire partie pour gestion du compte, mot de passe (pas prioritaire)
		Ecrire partie pour gérer les annonces de l'utilisateur (prioritaire)
	-->

	<!-- code php ci-dessous uniquement à titre indicatif, pour vérifier si le user est connecté, etc.. -->
	<?php
	echo "Connecté en tant que ".$_SESSION['pseudo'];
	?>
	
</body>
</html>