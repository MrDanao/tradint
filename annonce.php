<?php
session_start();
include 'includes/functions.php';
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
                  echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="compte/" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mon compte</a><div class="dropdown-menu" aria-labelledby="dropdown01"><a class="dropdown-item" href="compte/parametres">Gérer mon compte</a><a class="dropdown-item" href="compte/mesannonces/">Gérer mes annonces</a><a class="dropdown-item" href="deconnexion.php">Deconnexion</a></div></li>';
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

     
        <div class="container text-center">
            <?php 
                $table = showAnnonce();
            ?>
          	<h1><?php echo $table['nom']; ?></h1>
            <div class="row">
              <?php
                    //list($pseudoEmail, $pseudoTel) = showAnnonce();
                    
                    $table['photo2'] = "50_p1.png";
                    $table['photo3'] = "50_p1.png";
                    $i = 1;
                    while (isset($table['photo'.$i])&&$table['photo'.$i]!="") {
                      if($i!=3){
                        echo '<div class="col-md-6 img-cent" ><div class="mx-auto frame"><img src="src/photos/'.$table['photo'.$i].'" class="img-fluid mx-auto"></div></div>';
                      }
                      else{
                        echo '</div><div class="row"><div class="col-md-6 img-cent" ><div class="mx-auto frame"><img src="src/photos/'.$table['photo'.$i].'" class="img-fluid mx-auto"></div></div>';
                      }
                      $i++;

                    }
              ?>
            </div>
          <form action="" method="post">
            <input type="submit" name="submit" value="Contacter le vendeur"/>
          </form>
          
          <?php
          if (isset($_POST['submit'])) {
            if (isLogged()) {
              echo $table['email']."</br>".$table['numeroTel'];
            } else {
              echo "Connectez-vous pour afficher les contacts du vendeur";
            }
          }
          ?>
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