<?php
session_start();

// récupère les fonctions PHP
include '../../includes/functions.php';

// si user pas connecté, alors internaute est redirigé vers l'accueil
if (!isLogged()) {
	header('Location: ../../accueil.php');
}

// Modification de mot de passe
// si appui suir  le boutton "Modifier le mot de passe"
if (isset($_POST['change_pass'])) {

	// si un des trois champs est vide, alors affiche un message d'erreur
	// la variable dédiée aux error/log de la modification de mdp est $pass_change_log
	if (empty($_POST['current_passwd']) || empty($_POST['new_passwd']) || empty($_POST['new_passwd_confirm'])) {

		$pass_change_log = "Veuillez remplir tous les champs.";

	} else {

		// tous les champs sont remplis
		// récupération des valeurs des trois champs et du pseudo du user connecté

		$pseudo 			= $_SESSION['pseudo'];
		$current_passwd     = $_POST['current_passwd'];
		$new_passwd         = $_POST['new_passwd'];
		$new_passwd_confirm = $_POST['new_passwd_confirm'];

		if (checkPassword($pseudo, $current_passwd)) {

			if (($current_passwd == $new_passwd) && ($current_passwd == $new_passwd_confirm)) {

				$pass_change_log = "Le nouveau mot de passe est identique à l'ancien.";

			} else {

				if (changePassword($pseudo, $new_passwd, $new_passwd_confirm)) {

					$pass_change_log = "Votre mot de passe a bien été modifié.";

				} else {

					$pass_change_log = "Les deux nouveaux mots de passe ne sont pas identiques.";
				}

			}

		} else {
			
			$pass_change_log = "Mauvais mot de passe actuel.";

		}

	}

}

if (isset($_POST['delete_account'])) {

	$pseudo       = $_SESSION['pseudo'];
	$passwd_clair = $_POST['passwd'];

	if (checkPassword($pseudo, $passwd_clair)) {

		if (isset($_POST['confirm_deletion'])) {
			
			if (rmUser($pseudo)) {
				$user_rm_log = "La suppression de votre compte a été effectuée. Vous serez redirigé vers la page d'accueil dans quelques instants...";
				$_SESSION  = array();
				session_destroy();
				header('Location: ../../accueil.php');
			} else {
				$user_rm_log = "KO";
			}
		} else {
			$user_rm_log = "Vous devez confirmer la suppression.";
		}
	} else {
		$user_rm_log = "Mot de passe incorrect.";
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
		<li><a href="../../accueil.php">Accueil</a></li>
		<li><a href="../../poster/">Poster une annonce</a></li>
		<li><a href="../mesannonces/">Mon Compte/Mes Annonces (à mettre dans le menu déroulant)</a></li>
		<li><a href=".">Mon Compte/Paramètres (à mettre dans le menu déroulant)</a></li>
		<li><a href="../../deconnexion.php">Mon Compte/Se déconnecter (à mettre dans le menu déroulant)</a></li>
	</ul>
	<h1>ESPACE Mon Compte/Paramètres</h1>
	<h3>Modifier mon mot de passe</h3>
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
                <th colspan="3"><input type="submit" value="Modifier le mot de passe" name="change_pass"/></th>
            </tr>
            <tr>
                <th colspan="3" id="error">
                    <?php
                    if (isset($pass_change_log)) { echo $pass_change_log; }
                    ?>
                </th>
            </tr>
        </table>
    </form>

    <h3>Supprimer mon compte</h3>
    <p>Attention : la suppresion de votre compte entrainera également la suppression de toutes vos annonces postées.</p>

    <form action="index.php" method="post">
        <table>
        	<tr>
                <th colspan="3"><input type="password" name="passwd" placeholder="Mot de passe"/></th>
            </tr>
        	<tr>
                <th colspan="3"><input type="checkbox" name="confirm_deletion"/> Je confirme la suppression du compte</th>
            </tr>
            <tr>
                <th colspan="3"><input type="submit" value="Supprimer le compte" name="delete_account"/></th>
            </tr>
            <tr>
                <th colspan="3" id="error">
                    <?php
                    if (isset($user_rm_log)) { echo $user_rm_log; }
                    ?>
                </th>
            </tr>
        </table>
    </form>

</body>
</html>