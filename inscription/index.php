<?php
session_start();
include '../includes/functions.php';

if (isLogged()) {
	header('Location: ../accueil.php');
}

// si clique sur le bouton "Créer mon compte" (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// si un ou plusieurs champs manquants
	if ((count(array_filter($_POST)) != count($_POST)) || ($_POST['localisation'] == 'none')) {
    	$error = '<div class="alert alert-warning alert-dismissible fade show" role="alert"> Veuillez remplir tous les champs.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    
    // sinon, tous les champs sont remplis
	} else {

		$pseudo		   = $_POST['pseudo'];
		$email		   = $_POST['email'];
		$phone		   = $_POST['phone'];
		$localisation  = $_POST['localisation'];	
		$passwd 	   = $_POST['passwd'];
		$passwdconfirm = $_POST['passwdconfirm'];

		if ($passwd == $passwdconfirm) {

			// Vérifie si le pseudo renseigné est inexistant
			// fonction checkUserInexistance dans fichier ../includes/functions.php ligne 19
			if (checkUserInexistance($pseudo)) {
				// si true alors création du user dans la base de données
				// fonction insertUserDB dans le fichier ../includes/functions.php ligne 44
				if (insertUserDB($pseudo, $email, $phone, $localisation, $passwd)) {
					$error =  "Votre compte a bien été créé.</br>Vous serez redirigé vers la page de connexion dans 3 secondes...";
					//sleep(3);
					header('Location: ../connexion/');
				} else {
					$error = '<div class="alert alert-warning alert-dismissible fade show" role="alert"> Votre compte n\'a pas été créé.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
				}
			} else {
				$error = '<div class="alert alert-warning alert-dismissible fade show" role="alert"> Ce pseudo n\'est plus disponible.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
			}

		} else {
			$error = '<div class="alert alert-warning alert-dismissible fade show" role="alert"> Les mots de passes ne correspondent pas.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
		}
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
    	<link href="../style/css/bootstrap.css" rel="stylesheet">
    	<!-- CSS-->
    	<link href="../style/style.css" rel="stylesheet">
  	</head>
  	<body>
    	<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark ">
      		<div class="container">
	    	<a class="navbar-brand" href="../">TradINT</a>
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	        <div class="collapse navbar-collapse" id="navbarsExample07">
				<ul class="navbar-nav mr-auto">
		        	<li class="nav-item">
		            	<a class="nav-link" href="../accueil.php">Accueil</a>
		            </li>
		            <li class="nav-item">
            			<a class="nav-link" href="../poster/">Poster une annonce</a>
            		</li>
		            <li class="nav-item">
		            	<a class="nav-link" href="../connexion/">Connexion</a>
		            </li>
		            <li class="nav-item active">
		            	<a class="nav-link" href=".">Inscription</a>
		            </li>
	        	</ul>
	        </div>
	      </div>
	    </nav>
	    <div class="container corps">
			<h1 class="text-center">Créer un compte</h1>
			<form action="index.php" method="post" class="form-signin">
				<div class="form-row">
				    <div class="form-group col-md-12">
				    	<input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Pseudo">
				    </div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-12">
						<input type="email" class="form-control" id="email" name="email" placeholder="Email">
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-12">
						<input type="text" class="form-control" id="phone" name="phone" placeholder="Numéro de téléphone">
					</div>
				</div>
				<div class="form-row">
				    <div class="form-group col-md-12">
				      	<select id="inputState" name="localisation" class="form-control">
  				        	<?php 
                    		showOptions("localisation");
                    		?>
					    </select>
				    </div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-12">
						<input type="password" class="form-control" id="inputPassword4" name="passwd" placeholder="Mot de passe">
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-12">
						<input type="password" class="form-control" id="inputPassword5" name="passwdconfirm" placeholder="Confirmer le mot de passe">
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Valider</button>  
				<div class="form-row" style=" margin-top: 10px;">
				<?php if (isset($error)) { echo $error; } ?>
				</div>   
			</form>
	    </div>
		<script src="../style/js/jquery3.js"></script>
		<script src="../style/js/poppers.js"></script>
		<script src="../style/js/bootstrap.js"></script>
	</body>
</html>