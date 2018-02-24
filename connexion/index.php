<?php
session_start();
include '../includes/functions.php';

if (isLogged()) {
	header('Location: ../accueil.php');
}

// si clique sur le bouton "Connexion" (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// si un ou plusieurs champs manquants
	if (count(array_filter($_POST)) != count($_POST)) {
    	$error = '<div class="alert alert-warning alert-dismissible fade show" role="alert"> Veuillez remplir tous les champs.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    
    // sinon, tous les champs sont remplis
	} else {

		$pseudo = $_POST['pseudo'];	
		$passwd = $_POST['passwd'];

		// appel de la fonction connectUser située dans ../includes/functions.php ligne 128
		if (connectUser($pseudo, $passwd)) {
				$_SESSION['pseudo'] = $pseudo;
				header('Location: ../accueil.php');
		} else {
			$error = '<div class="alert alert-warning alert-dismissible fade show" role="alert">Le pseudo et le mot de passe sont incorrects.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
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
            <li class="nav-item ">
              <a class="nav-link" href="../accueil.php">Accueil <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../poster/">Poster une annonce</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href=".">Connexion</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../inscription/">Inscription <span class="sr-only">(current)</span></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container corps">
      <h1 class="text-center">Connexion</h1>
      <form action="index.php" method="post" class="form-signin">
		    <div class="form-row">
          <div class="form-group col-md-12">
            <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Pseudo">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
				    <input type="password" class="form-control" id="inputPassword4" name="passwd" placeholder="Mot de passe">
				  </div>
		    </div>
				<button type="submit" class="btn btn-primary">Se connecter</button>
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