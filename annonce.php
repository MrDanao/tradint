<?php
session_start();
include 'includes/functions.php';

// récupère la référence de l'annonce depuis l'URL : domain.tld/annonce.php?ref=[numéro_de_réf]
$refAnnonce = $_GET['ref'];

?>
<!DOCTYPE html>
<html>
<head>
	<title>Trad'INT - NOM ANNONCE A MODIFIER</title>
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
	//showAnnonce($refAnnonce);
	?>

	<!-- 
		Ecrire partie pour la Recherche d'annonce (prioritaire)

		Ecrire partie pour lister les dernières annonces (prioritaire)

		Ecrire partie pour la pagination (pas prioritaire)
	-->

</body>
</html>