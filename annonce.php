<?php
session_start();
include 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Trad'INT - NOM ANNONCE A MODIFIER</title>
	<meta charset="utf-8">
</head>
<body>
	<ul>
		<li><h2>Trad'INT</h2></li>
		<li><a href="accueil.php">Accueil</a></li>
		<li><a href="poster/">Poster une annonce</a></li>
		<?php
		if (isLogged()) {
			echo '<li><a href="compte/">Mon compte</a></li>
		<li><a href="deconnexion.php">Se déconnecter</a></li>';
		} else {
			echo '<li><a href="inscription/">Inscription</a></li>
		<li><a href="connexion/">Connexion</a></li>';
		}
		?>
	</ul>
	<h1>ESPACE dédiée à une annonce</h1>
	<?php
	list($pseudoEmail, $pseudoTel) = showAnnonce();
	?>
	<form action="" method="post">
		<input type="submit" name="submit" value="Contacter le vendeur"/>
	</form>
	
	<?php
	if (isset($_POST['submit'])) {
		if (isLogged()) {
			echo $pseudoEmail."</br>".$pseudoTel;
		} else {
			echo "Connectez-vous pour afficher les contacts du vendeur";
		}
	}
	?>
</body>
</html>