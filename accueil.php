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
        <a class="navbar-brand" href="#">TradINT</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
              <a class="nav-link" href="index.html">Accueil <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="accueil.php">Annonces</a>
            </li>
             <?php 
                if (isLogged()) {        
                  echo '<li class="nav-item"><a class="nav-link" href="poster/">Poster une annonce</a></li>'; 
                  echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="compte/" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mon compte</a><div class="dropdown-menu" aria-labelledby="dropdown01"><a class="dropdown-item" href="#">Gérer mon compte</a><a class="dropdown-item" href="#">Gérer mes annonces</a><a class="dropdown-item" href="deconnexion.php">Deconnexion</a></div></li>';
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
        <div class="container">
          	<h1 class="jumbotron-heading">Rechercher</h1>
          	<form action="accueil.php" method="post" class="form-signin-2">
				<div class="form-row">
				    <div class="form-group col-md-8">
				      <input type="text" class="form-control" id="recherche" name="recherche" placeholder="recherche">
				    </div>
					<div class="form-group col-md-4">
				      <select id="inputState" name="localisation" class="form-control">
				      	<option selected disabled="disabled">Votre localisation</option>
				      	<?php 
				      		
				      	$select_db 		  = connectDB();
							  $query    		  = "SELECT * FROM localisation ";
							  $result           = mysqli_query($select_db, $query);
							  while ($annonce = mysqli_fetch_assoc($result)) {
                    $idLocal    = $annonce['idLocal'];
                    $descLocal   = $annonce['descLocal'];
  							   	echo "<option value='$idLocal '>$descLocal </option>";
							  }
				      	?>
				      </select>
				    </div>
				  </div>
				<div class="form-row">
					<div class="form-group col-md-6">
				      <select id="inputState" name="categorie" class="form-control">
				        <option selected disabled="disabled">Catégorie</option>
				        <?php 
                  
                $select_db      = connectDB();
                $query          = "SELECT * FROM categorie ";
                $result           = mysqli_query($select_db, $query);
                while ($annonce = mysqli_fetch_assoc($result)) {
                    $idLocal    = $annonce['idCat'];
                    $descLocal   = $annonce['descCat'];
                    echo "<option value='$idLocal '>$descLocal </option>";
                }
                ?>
				      </select>
				    </div>
				    <div class="form-group col-md-6">
				      <select id="inputState" name="typeAnnonce" class="form-control">
				        <option selected disabled="disabled">Type d'annonce</option>
				        <?php 
                  
                $select_db      = connectDB();
                $query          = "SELECT * FROM type_annonce ";
                $result           = mysqli_query($select_db, $query);
                while ($annonce = mysqli_fetch_assoc($result)) {
                    $idLocal    = $annonce['idTypeAnnonce'];
                    $descLocal   = $annonce['descTypeAnnonce'];
                    echo "<option value='$idLocal '>$descLocal </option>";
                }
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
              showAccueilAnnonce();
            ?>
        </div>
      </div>

    </main>


	</div>
	<script src="style/js/jquery3.js"></script>
  	<script src="style/js/poppers.js"></script>
  	<script src="style/js/bootstrap.js"></script>
  	<script type="text/javascript">
  	</script>
  	
</body>
</html>