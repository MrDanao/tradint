<?php
session_start();
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (isset($_POST['recherche']) || isset($_POST['localisation']) || isset($_POST['categorie']) || isset($_POST['typeAnnonce'])) {

		$recherche	  = usedForSearch($_POST['recherche']);
		$typeAnnonce  = usedForSearch($_POST['typeAnnonce']);
		$categorie    = usedForSearch($_POST['categorie']);
		$localisation = usedForSearch($_POST['localisation']);

		header('Location: recherche.php?q='.$recherche.'&typ='.$typeAnnonce.'&cat='.$categorie.'&loc='.$localisation.'');
	} 
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Trad'INT - Accueil</title>
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
	<h1>ESPACE Annonces</h1>

	<form action="accueil.php" method="post">
        <table>
            <tr>
                <th colspan="3"><input type="text" name="recherche" placeholder="recherche"/></th>
            </tr>
            <tr>
            	<th colspan="3">
            		<select name="localisation">
					    <?php
					    showOptions("localisation");
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
	            <th colspan="3">
	            	<select name="typeAnnonce">
						<?php
						showOptions("type_annonce");
						?>
					</select>
	            </th>
	        </tr>
            <tr>
                <th colspan="3"><input type="submit" value="Rechercher"/></th>
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
	

	<?php
	showAccueilAnnonce();
	?>
	
	<!-- 
		Ecrire partie pour la Recherche d'annonce (prioritaire)

		Ecrire partie pour lister les dernières annonces (prioritaire)

		Ecrire partie pour la pagination (pas prioritaire)
	-->

</body>
</html>