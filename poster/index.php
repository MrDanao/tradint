<?php
session_start();
include '../includes/functions.php';

if (!isLogged()) {
	header('Location: ../connexion/');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['categorie']) && isset($_POST['typeAnnonce']) && !empty($_FILES['photo1']['tmp_name'])) {

		$utilisateur = $_SESSION['pseudo'];
		$titre 		 = $_POST['titre'];
		$typeAnnonce = $_POST['typeAnnonce'];
		$categorie   = $_POST['categorie'];
		$description = $_POST['description'];
		$photo1      = $_FILES['photo1'];
		$photo2      = isFileUp($_FILES['photo2']);
		$photo3      = isFileUp($_FILES['photo3']);

		if ($typeAnnonce == 1) {
			if ($_POST['prix'] > 0) {
				$prix = $_POST['prix'];
				addAnnonce($utilisateur, $titre, $typeAnnonce, $categorie, $description, $prix, $photo1, $photo2, $photo3);
			} else {
				echo "KO";
			}
		} else {
			$prix = "NULL";
			addAnnonce($utilisateur, $titre, $typeAnnonce, $categorie, $description, $prix, $photo1, $photo2, $photo3);
		}
	} else {
		echo "KO";
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
    <script type="text/javascript">
		function changeType() {
			if (document.getElementById('typeAnnonce').value != 1) {
				message = "";
				document.getElementById('prix').innerHTML = message;
            } else {
            	message = "<div  class=\"form-group col-md-4\"><input type=\"number\" min=\"0\" class=\"form-control\"  name=\"prix\" placeholder=\"Prix €\"></div>";
				document.getElementById('prix').innerHTML = message;
            }
		}
	</script>
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
              <a class="nav-link" href="../index.html">Accueil <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="../accueil.php">Annonces</a>
            </li>
             <?php 
                if (isLogged()) {        
                  echo '<li class="nav-item active"><a class="nav-link" href="../poster/">Poster une annonce</a></li>'; 
                  echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="compte/" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mon compte</a><div class="dropdown-menu" aria-labelledby="dropdown01"><a class="dropdown-item" href="../compte/parametres">Gérer mon compte</a><a class="dropdown-item" href="../compte/mesannonces/">Gérer mes annonces</a><a class="dropdown-item" href="deconnexion.php">Déconnexion</a></div></li>';
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
          	<h1 class="jumbotron-heading">Ajouter une annonce</h1>
          	<form action="index.php" method="post" enctype="multipart/form-data" class="form-signin">
          		<div class="form-row">
          			<div class="form-group col-md-12">
				      <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre de l'annonce" required="required">
				    </div>
          		</div>				
				      <div class="form-row">
					       <div class="form-group col-md-6">
				      <select id="inputState" name="categorie" class="form-control">
				        <option disabled selected>Catégorie</option>
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
				      <select id="typeAnnonce" name="typeAnnonce" class="form-control" onchange="changeType();">
				        <option disabled selected>Type d'annonce</option>
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
				<div id="prix" class="form-row">
          			
        </div>
				<div class="form-row">
          			<div class="form-group col-md-12">
				      <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="3" placeholder="Description de l'annonce"></textarea>
				    </div>
          		</div>
          		<div class="form-row">
          			<div class="form-group col-md-12">
				      <div class="custom-file">
				    	<input type="file" class="custom-file-input" name="photo1" accept="image/*" required>
				    	<label class="custom-file-label" for="validatedCustomFile">Photo 1</label>
				  	</div>
				    </div>
				</div>
				<div class="form-row">
          			<div class="form-group col-md-12">
				      <div class="custom-file">
				    	<input type="file" class="custom-file-input" name="photo2" accept="image/*">
				    	<label class="custom-file-label" for="validatedCustomFile">Photo 2</label>
				  	</div>
				    </div>
				</div>
				<div class="form-row">
          			<div class="form-group col-md-12">
				      <div class="custom-file">
				    	<input type="file" class="custom-file-input" name="photo3" accept="image/*">
				    	<label class="custom-file-label" for="validatedCustomFile">Photo 3</label>
				  	</div>
				    </div>
				</div>
					<button type="submit" class="btn btn-primary">Valider</button>
				  
				<div class="form-row" style=" margin-top: 10px;">
					<?php
		            	if (isset($error)) { echo $error; }
		            ?>
				</div>
			   
			</form>
        </div>
      </section>
    </main>


	</div>
	<script src="../style/js/jquery3.js"></script>
  	<script src="../style/js/poppers.js"></script>
  	<script src="../style/js/bootstrap.js"></script>
  	<script type="text/javascript">
  	</script>
  	
</body>
</html>
