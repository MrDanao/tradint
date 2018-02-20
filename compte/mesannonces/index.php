<?php
session_start();

// récupère les fonctions PHP
include '../../includes/functions.php';

// si user pas connecté, alors internaute est redirigé vers l'accueil
if (!isLogged()) {
    header('Location: ../../accueil.php');
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
            <li class="nav-item ">
              <a class="nav-link" href="../../accueil.php">Annonces</a>
            </li>
             <?php 
                if (isLogged()) {        
                  echo '<li class="nav-item"><a class="nav-link" href="../../poster/">Poster une annonce</a></li>'; 
                  echo '<li class="nav-item active dropdown"><a class="nav-link dropdown-toggle" href="compte/" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mon compte</a><div class="dropdown-menu" aria-labelledby="dropdown01"><a class="dropdown-item" href="../parametres/">Gérer mon compte</a><a class="dropdown-item" href="../mesannonces/">Gérer mes annonces</a><a class="dropdown-item" href="../../deconnexion.php">Deconnexion</a></div></li>';
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
          	<h1 class="jumbotron-heading">Gestion des annonces</h1>
        </div>
      </section>
      		<div class="album py-5 bg-light">
        		<div class="container">

          			<div class="row">
            			<?php
             				//showAccueilAnnonce();
             				showUserAnnonce();
            			?>
        			</div>
      			</div>
      		</div>
    	</main>
	</div>

	<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      	<div class="modal-dialog modal-lg" role="document">
        	<div class="modal-content">
          		<div class="modal-header">
          		<h5 class="modal-title" id="exampleModalLabel"></h5>
          		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
          		</button>
          	</div>
          <div class="modal-body">
          	<!--Formulaire de modification-->
            <form action="modify.php" method="post" enctype="multipart/form-data" class="form-signin" id="form-mod">
            	<input type="hidden" name="ref" class="modal-input">
            	<div class="form-row">
            		<label for="staticEmail" class="col-sm-3 col-form-label">Titre annonce :</label>
            		<div class="form-group col-md-9">
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
          			<div class="form-group col-md-4">
				      <div class="custom-file">
				    	<input type="file" class="custom-file-input" name="photo1" accept="image/*" required>
				    	<label class="custom-file-label" for="validatedCustomFile">Photo 1</label>
				  	</div>
				    </div>
          			<div class="form-group col-md-4">
				      <div class="custom-file">
				    	<input type="file" class="custom-file-input" name="photo2" accept="image/*">
				    	<label class="custom-file-label" for="validatedCustomFile">Photo 2</label>
				  	</div>
				    </div>
          			<div class="form-group col-md-4">
				      <div class="custom-file">
				    	<input type="file" class="custom-file-input" name="photo3" accept="image/*">
				    	<label class="custom-file-label" for="validatedCustomFile">Photo 3</label>
				  	</div>
				    </div>
				</div>
            </form>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
          <button type="button" class="btn btn-primary" onclick="modifier()">Modifier</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="supprimer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      	<div class="modal-dialog" role="document">
        	<div class="modal-content">
          		<div class="modal-header">
          		<h5 class="modal-title" id="exampleModalLabel">Suppression d'une annonce</h5>
          		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
          		</button>
          	</div>
          <div class="modal-body">
          	Vous êtes sur le point de supprimer votre annonce ! 
            <form action="delete.php" method="GET" id="form-sup">
            	<input type="hidden" name="ref">
            </form>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
          <button type="button" class="btn btn-danger" onclick="supprimer()">supprimer</button>

          </div>
        </div>
      </div>
    </div>



	<script src="../../style/js/jquery3.js"></script>
  	<script src="../../style/js/poppers.js"></script>
  	<script src="../../style/js/bootstrap.js"></script>
  	<script type="text/javascript">
  		$('#exampleModal').on('show.bs.modal', function (event) {
  			var button = $(event.relatedTarget) // Button that triggered the modal
  			var recipient = {
  				ref 	: button.data('whatever'),
  				title_A	: button.data('nom')
  			} // Extract info from data-* attributes
  			// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
 			// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  			var modal = $(this)
  			modal.find('.modal-title').text('Annonces' + recipient['title_A'])
  			modal.find('.modal-input').val(recipient['ref'])
		});


		$('#supprimer').on('show.bs.modal', function (event) {
  			var button = $(event.relatedTarget) // Button that triggered the modal
  			var recipient = button.data('whatever') // Extract info from data-* attributes
  			// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
 			// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  			var modal = $(this)
  			//modal.find('.modal-title').text('New message to ' + recipient)
  			//modal.find('.modal-body').text('Réference ' + recipient)
  			modal.find('.modal-body input').val(recipient)
		});

		function supprimer(){
			document.getElementById("form-sup").submit();
		}
		function modifier(){
			document.getElementById("form-mod").submit();
		}
		function changeType() {
			if (document.getElementById('typeAnnonce').value != 1) {
				message = "";
				document.getElementById('prix').innerHTML = message;
            } else {
            	message = "<label for=\"staticEmail\" class=\"col-sm-3 col-form-label\">Prix de l'article :</label><div  class=\"form-group col-md-4\"><input type=\"number\" min=\"0\" class=\"form-control\"  name=\"prix\" placeholder=\"prix\"> </div>";
				document.getElementById('prix').innerHTML = message;
            }
		}
  	</script>
  	
</body>
</html>


<!DOCTYPE html>
<html>
<head>
	<title>Trad'INT - Mes annonces</title>
	<meta charset="utf-8">
	<script type="text/javascript">
		function rmConfirm(ref) {
			if (confirm("Êtes-vous sûr de supprimer l'annonce ?")) {
				window.alert("L'annonce a été supprimée.");
				window.location.href = "delete.php?ref=" + ref;
			}
		}
	</script>
</head>
<body>
	<ul>
		<li><h2>Trad'INT</h2></li>
		<li><a href="">Accueil</a></li>
		<li><a href="">Poster une annonce</a></li>
		<li><a href=".">Mon Compte/Mes Annonces (à mettre dans le menu déroulant)</a></li>
		<li><a href="">Mon Compte/Paramètres (à mettre dans le menu déroulant)</a></li>
		<li><a href="">Mon Compte/Se déconnecter (à mettre dans le menu déroulant)</a></li>
	</ul>
	<h1>Gestion des annonces</h1>
	<?php
    	
    ?>
</body>
</html>