<?php
session_start();

// récupère les fonctions PHP
include '../../includes/functions.php';

// si user pas connecté, alors internaute est redirigé vers l'accueil
if (!isLogged()) {
    header('Location: ../../accueil.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Trad'INT - Mes annonces</title>
	<meta charset="utf-8">
</head>
<body>
	<ul>
		<li><h2>Trad'INT</h2></li>
		<li><a href="../../accueil.php">Accueil</a></li>
		<li><a href="../../poster/">Poster une annonce</a></li>
		<li><a href="..">Mon compte</a></li>
		<li><a href="../../deconnexion.php">Se déconnecter</a></li>
	</ul>
	<h1>Gestion des annonces</h1>
	<?php
    showUserAnnonce();
    ?>
</body>
</html>