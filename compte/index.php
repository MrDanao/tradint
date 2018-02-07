<?php
session_start();
include '../includes/functions.php';

if (!isLogged()) {
	header('Location: ../accueil.php');
}

if (isset($_POST['change_pass'])) {
	if (empty($_POST['current_passwd']) || empty($_POST['new_passwd']) || empty($_POST['new_passwd_confirm'])) {

		$error = "Veuillez remplir tous les champs.";

	} else {

		$pseudo 			= $_SESSION['pseudo'];
		$current_passwd     = $_POST['current_passwd'];
		$new_passwd         = $_POST['new_passwd'];
		$new_passwd_confirm = $_POST['new_passwd_confirm'];

		if (checkPassword($pseudo, $current_passwd)) {

			if (($current_passwd == $new_passwd) && ($current_passwd == $new_passwd_confirm)) {

				$error = "Le nouveau mot de passe est identique à l'ancien.";

			} else {

				if (changePassword($pseudo, $new_passwd, $new_passwd_confirm)) {

					$error = "Votre mot de passe a bien été modifié.";

				} else {

					$error = "Les deux nouveaux mots de passe ne sont pas identiques.";
				}

			}

		} else {
			
			$error = "Mauvais mot de passe actuel.";

		}

	}

}


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
	<h3>Gestion des annonces</h3>

	<!--
		Ecrire partie pour gestion du compte, mot de passe (pas prioritaire)
		Ecrire partie pour gérer les annonces de l'utilisateur (prioritaire)
	-->

	<!-- code php ci-dessous uniquement à titre indicatif, pour vérifier si le user est connecté, etc.. -->
	<?php
	showUserAnnonce();
	?>

	<h3>Modifier son mot de passe</h3>
	
	<form action="index.php" method="post">
        <table>
            <tr>
                <th colspan="3"><input type="password" name="current_passwd" placeholder="Mot de passe actuel"/></th>
            </tr>
            <tr>
                <th colspan="3"><input type="password" name="new_passwd" placeholder="Nouveau mot de passe"/></th>
            </tr>
            <tr>
                <th colspan="3"><input type="password" name="new_passwd_confirm" placeholder="Confirmer le mot de passe"/></th>
            </tr>
            <tr>
                <th colspan="3"><input type="submit" value="Modifier" name="change_pass"/></th>
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