<?php
session_start();

// récupère les fonctions PHP
include '../../includes/functions.php';

// si user pas connecté, alors internaute est redirigé vers l'accueil
if (!isLogged()) {
	header('Location: ../../accueil.php');
}

//récupération de la localisation de l'utilisateur
$localisation = getUserLocalisation($_SESSION['pseudo']);

// modification de la localisation de l'utilisateur
if (isset($_POST['changeLoc'])) {
	$pseudo = $_SESSION['pseudo'];
	$newLocalisation = $_POST['localisation'];
	if (changeLocalisation($pseudo, $newLocalisation)) {
		$loc_change_log = "Votre nouvelle localisation a bien été enregistrée.";
		header("Refresh:0");
	} else {
		$loc_change_log = "Erreur de changement de localisation;";
	}
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

// suppression du compte
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
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="../../../../favicon.ico">

    <title>TradINT</title>

    <!-- Bootstrap CSS -->
    <link href="../../style/css/bootstrap.css" rel="stylesheet">

    <!-- CSS-->
    <link href="../../style/style.css" rel="stylesheet">
    
  </head>
  <body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark ">
      <div class="container">
        <a class="navbar-brand" href="#">TradINT</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
              <a class="nav-link" href="../../index.html">Accueil <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="../../accueil.php">Annonces</a>
            </li>
             <?php 
                if (isLogged()) {        
                  echo '<li class="nav-item"><a class="nav-link" href="../../poster/">Poster une annonce</a></li>'; 
                  echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="compte/" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mon compte</a><div class="dropdown-menu" aria-labelledby="dropdown01"><a class="dropdown-item" href="../parametres">Gérer mon compte</a><a class="dropdown-item" href="../mesannonces/">Gérer mes annonces</a><a class="dropdown-item" href="../../deconnexion.php">Déconnexion</a></div></li>';
                } 
                else{
                  echo '<li class="nav-item"><a class="nav-link" href="./connexion/">Connexion</a></li>';
                  echo '<li class="nav-item"><a class="nav-link" href="./inscription/">Inscription <span class="sr-only">(current)</span></a></li>';
                }
              ?>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container corps">
    <main role="main">
    	<section class="jumbotron text-center">
	    	<div class="row">
	        	<div class="col-md-4">
	            	<h2>Localisation</h2>
	            	<form action="index.php" method="post">
	          			<div class="form-row">
							<div class="form-group col-md-12">
						      	<select id="inputState" name="localisation" class="form-control">
							        <?php
										showOptionsModify("localisation", $localisation);
						   			?>
						      	</select>
					    	</div>
						</div>
						<input type="submit" name="changeLoc" value="Modifier" class="btn btn-primary">
				  		<div class="form-row" style=" margin-top: 10px;">
							<?php
                    			if (isset($loc_change_log)) { echo $loc_change_log; }
                    		?>
						</div>
			   
					</form>
	          	</div>
	          	<!--Champs de mot de passe-->
	          	<div class="col-md-4">
	          		<h2>Mot de passe</h2>
			        <form action="index.php" method="post">
						<div class="form-row">
						  <div class="form-group col-md-12">
						    <input type="password" class="form-control" name="current_passwd" placeholder="Mot de passe actuel">
						  </div>
						</div>
						<div class="form-row">
						  <div class="form-group col-md-12">
						    <input type="password" class="form-control" name="new_passwd" placeholder="Nouveau mot de passe">
						  </div>
						</div>
						<div class="form-row">
					  		<div class="form-group col-md-12">
					    		<input type="password" class="form-control" name="new_passwd_confirm" placeholder="Confirmer le mot de passe">
							</div>
						</div>
						<input type="submit" value="Modifier" name="change_pass" class="btn btn-primary"/>
			  
						<div class="form-row" style=" margin-top: 10px;">
							<?php
                    			if (isset($pass_change_log)) { echo $pass_change_log; }
                   			?>
						</div>
					</form>
		        </div>
		        <!--Champs Supprimer compte-->
	         	<div class="col-md-4">
		            <h2>Supprimer compte</h2>
		            <form action="index.php" method="post">
						<div class="form-row">
						  <div class="form-group col-md-12">
						    <input type="password" class="form-control" name="passwd" placeholder="Mot de passe">
						  </div>
						</div>
						<div class="form-row">
						  <div class="form-group col-md-12">
						    <div class="form-check">
    							<input type="checkbox" class="form-check-input" name="confirm_deletion">
    							<label class="form-check-label" for="exampleCheck1">Je confirme la suppression du compte</label>
  							</div>
						  </div>
						</div>
						<input type="submit" class="btn btn-primary" value="Supprimer le compte" name="delete_account"/>
			  
						<div class="form-row" style=" margin-top: 10px;">
							<?php
                    			if (isset($user_rm_log)) { echo $user_rm_log; }
                    		?>
						</div>
					</form>
	          	</div>
	        </div>
	    </section>
    </main>


	</div>
	<script src="../../style/js/jquery3.js"></script>
  	<script src="../../style/js/poppers.js"></script>
  	<script src="../../style/js/bootstrap.js"></script>
  	<script type="text/javascript">
  	</script>
  	
</body>
</html>