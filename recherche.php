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
	<title>Trad'INT - Recherche</title>
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
	<h1>ESPACE Recherche</h1>

	<form action="recherche.php" method="post">
        <table>
            <tr>
                <th colspan="3"><input type="text" name="recherche" placeholder="recherche"/></th>
            </tr>
            <tr>
            	<th colspan="3">
            		<select name="localisation">
					    <option selected disabled>Votre localisation</option>
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
            	<th colspan="3">
            		<select name="categorie">
					    <option selected disabled>Catégorie</option>
					    <option value="1">Meubles</option>
					    <option value="2">Fournitures</option>
					    <option value="3">Cuisine</option>
					    <option value="4">Vêtements</option>
						<option value="5">Nourriture</option>
					</select>
            	</th>
            </tr>
            <th colspan="3">
            	<select name="typeAnnonce">
				    <option selected disabled>Type d'annonce</option>
				    <option value="1">Vente</option>
				    <option value="2">Échange</option>
				    <option value="3">Prêt</option>
				    <option value="4">Don</option>
				</select>
            </th>
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
	// récupération des données GET dans l'url
	$recherche    = $_GET['q'];
	$typeAnnonce  = $_GET['typ'];
	$categorie    = $_GET['cat'];
	$localisation = $_GET['loc'];
	// appel fonction de recherhe
	recherche($recherche, $categorie, $typeAnnonce, $localisation);
	?>
	
	<!-- 
		Ecrire partie pour la Recherche d'annonce (prioritaire)

		Ecrire partie pour lister les dernières annonces (prioritaire)

		Ecrire partie pour la pagination (pas prioritaire)
	-->

</body>
</html>