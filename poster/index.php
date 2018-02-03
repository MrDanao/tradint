<?php
session_start();
include '../includes/functions.php';

if (!isLogged()) {
	header('Location: ../connexion/');
}

// à compléter

?>
<!DOCTYPE html>
<html>
<head>
	<title>Trad'INT - Poster une annonce</title>
</head>
<body>
	<ul>
		<li><h2>Trad'INT</h2></li>
		<li><a href="../annonces/">Accueil</a></li>
		<li><a href="../post/">Poster une annonce</a></li>
		<li><a href="../compte/">Mon compte</a></li>
		<li><a href="../deconnexion.php">Se déconnecter</a></li>
	</ul>
	<h1>ESPACE Poster une annonce</h1>
	
	<!-- écrire code -->

</body>
</html>