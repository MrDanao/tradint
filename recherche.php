<?php
session_start();
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (isset($_POST['recherche']) || isset($_POST['localisation']) || isset($_POST['categorie']) || isset($_POST['typeAnnonce'])) {

		$recherche	  = usedForSearch(isset($_POST['recherche'])?$_POST['recherche']:NULL);
		$typeAnnonce  = usedForSearch(isset($_POST['typeAnnonce'])?$_POST['typeAnnonce']:NULL);
		$categorie    = usedForSearch(isset($_POST['categorie'])?$_POST['categorie']:NULL);
		$localisation = usedForSearch(isset($_POST['localisation'])?$_POST['localisation']:NULL);

    $typeAnnonce  = rtrim($typeAnnonce);
    $categorie    = rtrim($categorie);
    $localisation = rtrim($localisation);
    
		header('Location: recherche.php?q='.$recherche.'&typ='.$typeAnnonce.'&cat='.$categorie.'&loc='.$localisation.'');
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
    <link href="style/css/bootstrap.css" rel="stylesheet">
    <!-- CSS-->
    <link href="style/style.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark ">
      <div class="container">
        <a class="navbar-brand" href=".">TradINT</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExample07">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="accueil.php">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="poster/">Poster une annonce</a>
            </li>
            <?php 
            if (isLogged()) {        
              echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="compte/" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mon compte</a><div class="dropdown-menu" aria-labelledby="dropdown01"><a class="dropdown-item" href="compte/parametres">Gérer mon compte</a><a class="dropdown-item" href="compte/mesannonces/">Gérer mes annonces</a><a class="dropdown-item" href="deconnexion.php">Déconnexion</a></div></li>';
            } else {
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
          <div class="container">
            <h1 class="jumbotron-heading">Rechercher</h1>
            <form action="accueil.php" method="post" class="form-signin-2">
  				    <div class="form-row">
                <div class="form-group col-md-8">
  				        <input type="text" class="form-control" id="recherche" name="recherche" placeholder="Recherche">
  				      </div>
                <div class="form-group col-md-4">
                  <select id="inputState" name="localisation" class="form-control">
                    <?php 
                    showOptions("localisation");
                    ?>
                  </select>
  				      </div>
  				    </div>
  				    <div class="form-row">
                <div class="form-group col-md-6">
                  <select id="inputState" name="categorie" class="form-control">
                    <?php 
                    showOptions("categorie");
                    ?>
  				        </select>
  				      </div>
  				      <div class="form-group col-md-6">
  				        <select id="inputState" name="typeAnnonce" class="form-control">
  				          <?php 
                    showOptions("type_annonce");
                    ?>
  				        </select>
  				      </div>
  				    </div>
              <button type="submit" class="btn btn-primary">Rechercher</button>
              <div class="form-row" style=" margin-top: 10px;">
              <?php
  		        if (isset($error)) { echo $error; }
              ?>
              </div>
            </form>
          </div>
        </section>
        <div class="album py-5 bg-light">
          <div class="container">
            <div class="row">
            <?php
  				  // récupération des données GET dans l'url
  				  $recherche    = $_GET['q'];
  				  $typeAnnonce  = $_GET['typ'];
  				  $categorie    = $_GET['cat'];
  				  $localisation = $_GET['loc'];
  				  // appel fonction de recherhe
  				  recherche($recherche, $categorie, $typeAnnonce, $localisation);
            ?>
            </div>
          </div>
        </div>
      </main>
    </div>
    <script src="style/js/jquery3.js"></script>
  	<script src="style/js/poppers.js"></script>
  	<script src="style/js/bootstrap.js"></script>
  </body>
</html>