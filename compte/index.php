<?php
session_start();
include '../includes/functions.php';

if (!isLogged()) {
	header('Location: ../accueil.php');
}

$pseudo = $_SESSION['pseudo'];
// à compléter

?>
<!DOCTYPE html>
<html>
<head>
	<title>Trad'INT - Compte</title>
	<meta charset="utf-8">
</head>
<body>
	<ul>
		<li><h2>Trad'INT</h2></li>
		<li><a href="../accueil.php">Accueil</a></li>
		<li><a href="../poster/">Poster une annonce</a></li>
		<li><a href="../compte/">Mon compte</a></li>
		<li><a href="../deconnexion.php">Se déconnecter</a></li>
	</ul>
	<h1>ESPACE Compte</h1>
	<h3>Gestion des annonces de l'utilisateur <?php echo $pseudo; ?></h3>

	<!--
		Ecrire partie pour gestion du compte, mot de passe (pas prioritaire)
		Ecrire partie pour gérer les annonces de l'utilisateur (prioritaire)
	-->

	<!-- code php ci-dessous uniquement à titre indicatif, pour vérifier si le user est connecté, etc.. -->
	<?php
	showUserAnnonce($pseudo);
	?>
	
</body>
</html>