<?php

	// pour vérifier si une session a été établie
	function isLogged() {
        if (isset($_SESSION['pseudo'])) {
            return true;
        } else {
            return false;
        }
    }

    // pour se connecter à la base de données et sélection de la base 'tradint'
	function connectDB() {
		$conn = mysqli_connect("localhost", "admintradint", "q>Z^mY]#[P`4ej&d", "tradint");
		return $conn;
	}

	// pour vérifier l'inexistance d'un user dans la table 'utilisateur' de la base 'tradint'
	function checkUserInexistance($new_user) {
		
		$select_db = connectDB();
		$query	   = "SELECT pseudo FROM utilisateur WHERE pseudo='".$new_user."';";
		$result    = mysqli_query($select_db, $query);
		
		// si le résultat de le requête retourne 1 seule ligne, alors l'utilisateur existe dans la table 'utilisateur' de la base 'tradint'
		if (mysqli_num_rows($result) == 1) {
			return false;
		} else {
			return true;
		}
	}

	// pour hashing et salting du mot de passe en clair renseigné en paramètre $passwd_clair
	function HashAndSalting($passwd_clair) {
		
		$options       = ['cost' => 10, 'salt' => random_bytes(128)];
		$salt		   = $options['salt'];
		$hashed_passwd = password_hash($passwd_clair, PASSWORD_BCRYPT, $options);

		// retourne un couple (mot de passe hashé, salt) c'est ce couple qui sera stocké dans la table 'utilisateur' de la base 'tradint'
		return array($hashed_passwd, $salt);
		
	}

	// pour ajouter un user dans la table 'utilisateur' de la base 'tradint'
	function insertUserDB($pseudo, $email, $phone, $localisation, $passwd) {
		// récupère le mot de passe hashé et le salt depuis la fonction HashAndSalting ligne 34
		list($hashed_passwd, $salt) = HashAndSalting($passwd);
		$select_db                  = connectDB();
		$query	                    = "INSERT INTO `utilisateur` (`pseudo`, `passwd`, `email`, `numeroTel`, `salt`, `idLocal`) VALUES ('".$pseudo."', '".$hashed_passwd."', '".$email."', '".$phone."', '".$salt."', '".$localisation."');";
		echo $query;
		$result	= mysqli_query($select_db, $query);
		
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	function rmUser($pseudo) {
		
		$select_db = connectDB();

		// suppresion des photos des annonces de l'utilisateur à supprimer
		$query     = "SELECT reference FROM annonce WHERE pseudo='".$pseudo."'";
		$result    = mysqli_query($select_db, $query);

		while ($annonce = mysqli_fetch_assoc($result)) {

			$reference = $annonce['reference'];
			
			foreach (glob("../src/photos/".$reference."_*") as $filename) {
				unlink($filename);
			}
		}

		// suppression des annonces
		$queryRmAnnonce  = "DELETE FROM `annonce` WHERE `annonce`.`pseudo` = '".$pseudo."'";
		$resultRmAnnonce = mysqli_query($select_db, $queryRmAnnonce);

		// suppression du compte
		$queryRmUser  = "DELETE FROM `utilisateur` WHERE `utilisateur`.`pseudo` = '".$pseudo."'";
		$resultRmUser = mysqli_query($select_db, $queryRmUser);

		if ($resultRmAnnonce && $resultRmUser) {
			return true;
		} else {
			return false;
		}

	}

	function checkPassword($pseudo, $passwd_clair) {
		$select_db        = connectDB();
		$query            = "SELECT pseudo,passwd,salt FROM utilisateur WHERE pseudo='".$pseudo."';";
		$result           = mysqli_query($select_db, $query);
		
		$row              = mysqli_fetch_assoc($result);
		$hashed_passwd_db = $row['passwd'];
		$salt_db          = $row['salt'];
		$options          = ['cost' => 10, 'salt' => $salt_db];
		$hashed_passwd    = password_hash($passwd_clair, PASSWORD_BCRYPT, $options);
		if ($hashed_passwd == $hashed_passwd_db) {
			return true;
		} else {
			return false;
		}
	}

	function changePassword($pseudo, $new_passwd, $new_passwd_confirm) {
		if ($new_passwd == $new_passwd_confirm) { 
			list($hashed_passwd, $salt) = HashAndSalting($new_passwd);
			$select_db                  = connectDB();
			$query	                    = "UPDATE `utilisateur` SET `passwd` = '".$hashed_passwd."', `salt` = '".$salt."' WHERE `utilisateur`.`pseudo` = '".$pseudo."'";
		
			$result	= mysqli_query($select_db, $query);
		
			if ($result) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}


	// pour checker pseudo et mot de passe lors de la connexion
	function connectUser($pseudo, $passwd_clair) {

		// vérifie l'inexistance du pseudo
		if (!checkUserInexistance($pseudo)) {

			// si existant, on récupère le mot de passe hashé et le salt stockés dans la table 'utilisateur' de la base 'tradint'
			if (checkPassword($pseudo, $passwd_clair)) {
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}

	}

		// pour lister les dernières annonces avec pagination, notamment utilisée dans la page d'accueil (accueil.php, ligne 32)
	function showAccueilAnnonce() {
		
		$select_db 		  = connectDB();
		$query    		  = "SELECT COUNT(*) AS nb_annonce FROM annonce";
		$result           = mysqli_query($select_db, $query);
		$row 			  = mysqli_fetch_assoc($result);
		$nbTotalAnnonce   = $row['nb_annonce'];
		$nbAnnonceParPage = 6;
		$nbTotalPage      = ceil($nbTotalAnnonce / $nbAnnonceParPage);

		if (isset($_GET['page'])) {
    		$pageCourante = $_GET['page'];
		    if ($pageCourante > $nbTotalPage) {
        		$pageCourante = $nbTotalPage;
        		header('Location: accueil.php?page='.$pageCourante.'');
    		}
		} else {
    		$pageCourante = 1; 
		}

		$premiereEntree = ($pageCourante-1)*$nbAnnonceParPage;

		$query     = "SELECT reference,nom,prix,photo1,typ.descTypeAnnonce, local.descLocal FROM annonce ann, type_annonce typ, utilisateur user, localisation local WHERE ann.idTypeAnnonce=typ.idTypeAnnonce AND ann.pseudo=user.pseudo AND user.idLocal=local.idLocal ORDER BY reference DESC LIMIT ".$premiereEntree.",".$nbAnnonceParPage."";
		$result    = mysqli_query($select_db, $query);

		while ($annonce = mysqli_fetch_assoc($result)) {

			$reference    = $annonce['reference'];
			$nomAnnonce   = $annonce['nom'];
			//$photo1	 	  = $annonce['photo1'];
			$photo1	 	  = ($annonce['photo1']==NULL)?"../bg/no_png.png":$annonce['photo1'];
			$typeAnnonce  = $annonce['descTypeAnnonce'];
			$prix		  = $annonce['prix'];
			$localisation = $annonce['descLocal'];


			if ($typeAnnonce != "Vente") {
				echo '<div class="col-md-4">'."\n\t".'<div class="card mb-4 box-shadow">'."\n\t\t".'<img class="card-img-top" src="src/photos/'.$photo1.'" alt="Card image cap">'."\n\t\t".'<div class="card-body">'."\n\t\t\t".'<h5 style="color: #696969;"><strong>'.$nomAnnonce.'</strong> </h5>'."\n".'<p style="margin-top: -10px;"><small>'.$typeAnnonce.', '.$localisation.'</small></p>'."\n\t\t".'<div class="d-flex justify-content-between align-items-center">'."\n\t\t".'<div class="btn-group">'."\n\t\t\t".'<a role="button" href="annonce.php?ref='.$reference.'" class="btn btn-sm btn-outline-secondary">Voir</a>'."\n\t\t".'</div>'."\n\t\t".'</div></div></div></div>';
			} else {
				// à changer avec bon code html/css
				echo '<div class="col-md-4">'."\n\t".'<div class="card mb-4 box-shadow">'."\n\t\t".' <img class="card-img-top" src="src/photos/'.$photo1.'" alt="Card image cap">'."\n\t\t".'<div class="card-body">'."\n\t\t\t".'<h5 style="color: #696969;"><strong>'.$nomAnnonce.'</strong> </h5>'."\n".'<p style="margin-top: -10px;"><small>'.$typeAnnonce.', '.$localisation.'</small></p><p style="margin-top: -20px;"><small>'.$prix.' €</small></p>'."\n\t\t".'<div class="d-flex justify-content-between align-items-center">'."\n\t\t".'<div class="btn-group">'."\n\t\t\t".'<a role="button" href="annonce.php?ref='.$reference.'" class="btn btn-sm btn-outline-secondary">Voir</a>'."\n\t\t".'</div>'."\n\t\t".'</div></div></div></div>';
			}
		}
		echo "</div>";
		
		echo '<nav aria-label="Page navigation example"><ul class="pagination">';
		if ($nbTotalAnnonce <= $nbAnnonceParPage) {
			echo '<li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li><li class="page-item disabled"><a class="page-link" href="#">1/1</a></li><li class="page-item disabled"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
		} elseif ($pageCourante == 1) {
			$pageSuivante = $pageCourante+1;
			echo '<li class="page-item disabled"><a class="page-link " href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li><li class="page-item disabled"><a class="page-link" href="#">1/'.$nbTotalPage.'</a></li><li class="page-item"><a class="page-link" href="accueil.php?page='.$pageSuivante.'" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
		} elseif ($pageCourante > 1 && $pageCourante < $nbTotalPage) {
			$pageSuivante = $pageCourante+1;
			$pagePrecedente = $pageCourante-1;
			echo '<li class="page-item "><a class="page-link" href="accueil.php?page='.$pagePrecedente.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li><li class="page-item disabled"><a class="page-link" href="#">'.$pageCourante.'/'.$nbTotalPage.'</a></li><li class="page-item"><a class="page-link" href="accueil.php?page='.$pageSuivante.'" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
		} elseif ($pageCourante == $nbTotalPage) {
			$pagePrecedente = $pageCourante-1;
			echo '<li class="page-item "><a class="page-link" href="accueil.php?page='.$pagePrecedente.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li><li class="page-item disabled"><a class="page-link" href="#">'.$nbTotalPage.'/'.$nbTotalPage.'</a></li><li class="page-item disabled"><a class="page-link " href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
		}
		echo '</ul></nav>';

	}


	// pour afficher l'annonce (appelé dans le fichier annonce.php, ligne 33)
	// function à refaire !!!!!!
	function showAnnonce() {

		$refAnnonce  = $_GET['ref'];
		$select_db   = connectDB();
		$query       = "SELECT DISTINCT ann.nom, ann.descriptif, ann.prix, ann.photo1, ann.photo2, ann.photo3, ann.pseudo, ann.dateAjout, typ.descTypeAnnonce, cat.descCat, user.email, user.numeroTel FROM annonce ann, categorie cat, type_annonce typ, utilisateur user WHERE ann.reference='".$refAnnonce."' and ann.idTypeAnnonce=typ.idTypeAnnonce and ann.idCat=cat.idCat and ann.pseudo=user.pseudo";
		$result      = mysqli_query($select_db, $query);
		$row         = mysqli_fetch_assoc($result);

		// récupération des données propres à l'annonce
		//$reference   = $row['reference'];
		//$pseudo      = $row['pseudo'];
		//$pseudoEmail = $row['email'];
		//$pseudoTel   = $row['numeroTel'];
		//$nomAnnonce  = $row['nom'];
		//$prix	     = $row['prix'];
		//$photo1	     = $row['photo1'];
		//$dateAjout	 = $row['dateAjout'];
		//$categorie   = $row['descCat'];
		//$typeAnnonce = $row['descTypeAnnonce'];
		//$descriptif  = $row['descriptif'];
		// AJOUTER PHOTO 2 ET PHOTO 3.

		// à changer avec bon code html/css
		//echo $nomAnnonce."</br>";
		//echo '<img src="src/photos/'.$photo1.'"></br>';
		//if ($typeAnnonce != "Vente") {
		//	echo $typeAnnonce."</br>";
		//} else {
		//	echo $typeAnnonce." - ".$prix."€</br>";
		//}
		//echo $descriptif;

		//return array($pseudoEmail, $pseudoTel);
		return $row;

	}

	function isPhoto($photo) {

		if ($photo == 'NULL') {
			return $photo;
		} else {
			return "'".$photo['name']."'";
		}

	}

	// fonction pour uploader une image dans le serveur + mise à jour da la base de données
	// le quatrième paramètres $link complète le chemin relatif de la destination du fichier photo
	// ce paramètre est notamment utilisé pour la Modification d'Annonce (voir fonction modPhoto()) où $link = "../"
	// pour l'ajout d'un annonce, $link = NULL
	function UploadInsertPhoto($photo, $id, $number, $link) {

		$tmpPathFile = $photo['tmp_name'];
        $tmpMimeFile = $photo['type'];
            		
        switch ($tmpMimeFile) {
        	
        	case 'image/jpeg':
          		$file_destination = ''.$link.'../src/photos/'.$id.'_p'.$number.'.jpg';
           		if (move_uploaded_file($tmpPathFile, $file_destination)) {
           			$select_db = connectDB();
           			$query = "UPDATE `annonce` SET `photo".$number."` = '".$id."_p".$number.".jpg' WHERE `annonce`.`reference` = ".$id."";
					$result = mysqli_query($select_db, $query);
               		return true;
           		} else {
               		return false;
           		}
           		break;
           	
           	case 'image/png':
          		$file_destination = ''.$link.'../src/photos/'.$id.'_p'.$number.'.png';
           		if (move_uploaded_file($tmpPathFile, $file_destination)) {
           			$select_db = connectDB();
           			$query = "UPDATE `annonce` SET `photo".$number."` = '".$id."_p".$number.".png' WHERE `annonce`.`reference` = ".$id."";
					$result = mysqli_query($select_db, $query);
               		return true;
           		} else {
               		return false;
           		}
           		break;
        }

	}

	function addAnnonce($utilisateur, $titre, $typeAnnonce, $categorie, $description, $prix, $photo1, $photo2, $photo3) {

		$select_db   = connectDB();
		// pour ajouter un anti-slash \ avant un caractère spécial
		$titre 		 = mysqli_real_escape_string($select_db, $titre);
		$description = mysqli_real_escape_string($select_db, $description);
		$query       = "INSERT INTO `annonce` (`reference`, `nom`, `descriptif`, `prix`, `dateAjout`, `photo1`, `photo2`, `photo3`, `pseudo`, `idTypeAnnonce`, `idCat`) VALUES (NULL, '".$titre."', '".$description."', ".$prix.", CURRENT_TIMESTAMP, 'nomPhoto1', NULL, NULL, '".$utilisateur."', '".$typeAnnonce."', '".$categorie."')";
		//echo $query; // pour debug
		$result      = mysqli_query($select_db, $query);

		if ($result) {
			echo "Annonce ajoutée dans la base de données.";
			// à partir d'ici, l'annonce est bien ajouté dans la base de données mais pas les bons nom de fichiers de photo. Le code qui suit permet de nommer correctement les photos, de les uploader et d'insérer le nom dans la base de données.
			// donne la valeur de la PRIMARY_KEY du dernier INSERT dans la table. Cette valeur sera utilisée pour nommer le fichier photo
			$id 	= mysqli_insert_id($select_db);
			$photos = array($photo1, $photo2, $photo3);
			$number = 1; // valeur qui s'incrémentera : 1 > photo1 ; 2 > photo2 ; 3 > photo3

			foreach ($photos as $photo_to_up) {

				if (isPhoto($photo_to_up) != 'NULL') {
					if (UploadInsertPhoto($photo_to_up, $id, $number, "")) {
						echo 'La photo '.$number.' a été ajoutée.';
					} else {
						echo 'La photo '.$number.' n\'a pas été ajoutée.';
					}
					$number++;
				}
			}

			header('Location: ../annonce.php?ref='.$id.''); 

		} else {
			echo "fail";
		}
	}

	function rmAnnonce($pseudo, $reference) {

		$select_db = connectDB();

		// suppression des annonces
		$queryRmAnnonce  = "DELETE FROM `annonce` WHERE `annonce`.`pseudo` = '".$pseudo."' AND `annonce`.`reference` = '".$reference."'";
		$resultRmAnnonce = mysqli_query($select_db, $queryRmAnnonce);

		if (mysqli_affected_rows($select_db) == 1) {
			foreach (glob("../../src/photos/".$reference."_*") as $filename) {
				unlink($filename);
			}
			return true;
		} else {
			return false;
		}

	}
	function getDataAnnonce($pseudo, $reference) {

		$select_db = connectDB();
		$query     = "SELECT ann.pseudo,ann.nom,ann.descriptif,ann.prix,ann.photo1,ann.photo2,ann.photo3,typ.descTypeAnnonce,cat.descCat,ann.idTypeAnnonce,ann.idCat FROM annonce ann, type_annonce typ, categorie cat WHERE pseudo='".$pseudo."' AND reference='".$reference."' AND ann.idTypeAnnonce=typ.idTypeAnnonce AND ann.idCat=cat.idCat";
		$result    = mysqli_query($select_db, $query);
		$annonce   = mysqli_fetch_assoc($result);

		$nom           = $annonce['nom'];
		$description   = $annonce['descriptif'];
		$typeAnnonce   = $annonce['descTypeAnnonce'];
		$typeAnnonceID = $annonce['idTypeAnnonce'];
		$categorie     = $annonce['descCat'];
		$categorieID   = $annonce['idCat'];
		$prix          = $annonce['prix'];
		$photo1        = $annonce['photo1'];
		$photo2        = $annonce['photo2'];
		$photo3        = $annonce['photo3'];

		return array($nom, $description, $typeAnnonce, $typeAnnonceID, $categorie, $categorieID, $prix, $photo1, $photo2, $photo3);

	}
	
	function showUserAnnonce() {

		$pseudo = $_SESSION['pseudo'];

		$select_db 		  = connectDB();
		$query    		  = "SELECT COUNT(*) AS nb_annonce FROM annonce WHERE pseudo='".$pseudo."'";
		$result           = mysqli_query($select_db, $query);
		$row 			  = mysqli_fetch_assoc($result);
		$nbTotalAnnonce   = $row['nb_annonce'];
		$nbAnnonceParPage = 6;
		$nbTotalPage      = ceil($nbTotalAnnonce / $nbAnnonceParPage);

		if (isset($_GET['page'])) {
    		$pageCourante = $_GET['page'];
		    if ($pageCourante > $nbTotalPage) {
        		$pageCourante = $nbTotalPage;
        		header('Location: mesannonces.php?page='.$pageCourante.'');
    		}
		} else {
    		$pageCourante = 1; 
		}

		$premiereEntree = ($pageCourante-1)*$nbAnnonceParPage;

		$query     = "SELECT reference,nom,prix,photo1,typ.descTypeAnnonce, local.descLocal FROM annonce ann, type_annonce typ, utilisateur user, localisation local WHERE ann.pseudo='".$pseudo."' AND ann.idTypeAnnonce=typ.idTypeAnnonce AND ann.pseudo=user.pseudo AND user.idLocal=local.idLocal ORDER BY reference DESC LIMIT ".$premiereEntree.",".$nbAnnonceParPage."";
		$result    = mysqli_query($select_db, $query);

		
		while ($annonce = mysqli_fetch_assoc($result)) {

			$reference    = $annonce['reference'];
			$nomAnnonce   = $annonce['nom'];
			$photo1	 	  = $annonce['photo1'];
			$typeAnnonce  = $annonce['descTypeAnnonce'];
			$prix		  = $annonce['prix'];
			$localisation = $annonce['descLocal'];

			list($nomdb, $descriptiondb, $typeAnnoncedb, $typeAnnonceIDdb, $categoriedb, $categorieIDdb, $prixdb, $photo1db, $photo2db, $photo3db) = getDataAnnonce($pseudo, $reference);

			$prixdb = !empty($prixdb)?$prixdb:"Pas de prix";

			if ($typeAnnonce != "Vente") {
				echo '<div class="col-md-4">'."\n\t".'<div class="card mb-4 box-shadow">'."\n\t\t".' <img class="card-img-top" src="../../src/photos/'.$photo1.'" alt="Card image cap">'."\n\t\t".'<div class="card-body">'."\n\t\t\t".'<h5 style="color: #696969;"><strong>'.$nomAnnonce.'</strong> </h5>'."\n".'<p style="margin-top: -10px;"><small>'.$typeAnnonce.', '.$localisation.'</small></p>'."\n\t\t".'<div class="d-flex justify-content-between align-items-center">'."\n\t\t".'<div class="btn-group">'."\n\t\t\t".'<button type="button" class="btn" data-toggle="modal" data-target="#exampleModal" data-whatever="'.$reference.'" data-nom="'.$nomAnnonce.'" data-dsc="'.$descriptiondb.'" data-typ="'.$typeAnnoncedb.'" data-cat="'.$categoriedb.'" data-prx="'.$prixdb.'">Modifier</button><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#supprimer" data-whatever="'.$reference.'">Supprimer</button> '."\n\t\t".'</div>'."\n\t\t".'</div></div></div></div>';
			} else {
				// à changer avec bon code html/css
				echo '<div class="col-md-4">'."\n\t".'<div class="card mb-4 box-shadow">'."\n\t\t".' <img class="card-img-top" src="../../src/photos/'.$photo1.'" alt="Card image cap">'."\n\t\t".'<div class="card-body">'."\n\t\t\t".'<h5 style="color: #696969;"><strong>'.$nomAnnonce.'</strong> </h5>'."\n".'<p style="margin-top: -10px;"><small>'.$typeAnnonce.', '.$localisation.'</small></p><p style="margin-top: -20px;"><small>'.$prix.' €</small></p>'."\n\t\t".'<div class="d-flex justify-content-between align-items-center">'."\n\t\t".'<div class="btn-group">'."\n\t\t\t".'<button type="button" class="btn" data-toggle="modal" data-target="#exampleModal" data-whatever="'.$reference.'" data-nom="'.$nomAnnonce.'" data-dsc="'.$descriptiondb.'" data-typ="'.$typeAnnoncedb.'" data-cat="'.$categorieIDdb.'" data-prx="'.$prixdb.'">Modifier</button><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#supprimer" data-whatever="'.$reference.'">Supprimer</button> '."\n\t\t".'</div>'."\n\t\t".'</div></div></div></div>';
			}
		}
		echo "</div>";
		
		echo '<nav aria-label="Page navigation example"><ul class="pagination">';
		if ($nbTotalAnnonce <= $nbAnnonceParPage) {
			echo '<li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li><li class="page-item disabled"><a class="page-link" href="#">1/1</a></li><li class="page-item disabled"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
		} elseif ($pageCourante == 1) {
			$pageSuivante = $pageCourante+1;
			echo '<li class="page-item disabled"><a class="page-link " href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li><li class="page-item disabled"><a class="page-link" href="#">1/'.$nbTotalPage.'</a></li><li class="page-item"><a class="page-link" href="index.php?page='.$pageSuivante.'" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
		} elseif ($pageCourante > 1 && $pageCourante < $nbTotalPage) {
			$pageSuivante = $pageCourante+1;
			$pagePrecedente = $pageCourante-1;
			echo '<li class="page-item "><a class="page-link" href="index.php?page='.$pagePrecedente.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li><li class="page-item disabled"><a class="page-link" href="#">'.$pageCourante.'/'.$nbTotalPage.'</a></li><li class="page-item"><a class="page-link" href="index.php?page='.$pageSuivante.'" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
		} elseif ($pageCourante == $nbTotalPage) {
			$pagePrecedente = $pageCourante-1;
			echo '<li class="page-item "><a class="page-link" href="index.php?page='.$pagePrecedente.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li><li class="page-item disabled"><a class="page-link" href="#">'.$nbTotalPage.'/'.$nbTotalPage.'</a></li><li class="page-item disabled"><a class="page-link " href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
		}
		echo '</ul></nav>';
	}

	function isFileUp($filePhoto) {

		if (is_uploaded_file($filePhoto['tmp_name'])) {
			return $filePhoto;
		} else {
			return "NULL";
		}

	}

	// fonction liée à la fonction recherche()
	// Dans le moteur de recherche, les différents champs du formulaire de recherche ne sont pas tous forcément remplis. Par conséquent, cette fonction ci-dessous va attribuer la valeur "%" à la variable d'un champ vide (critère).
	function usedForSearch($critere) {

		if (empty($critere)) {
			return "%";
		} else {
			return $critere;
		}

	}

	function recherche($getRecherche, $getCategorie, $getTypeAnnonce, $getLocalisation) {
		

		$select_db 		  = connectDB();
		$query    		  = "SELECT COUNT(*) AS nb_annonce FROM annonce ann, type_annonce typ, utilisateur user, localisation local WHERE ann.idTypeAnnonce=typ.idTypeAnnonce AND ann.pseudo=user.pseudo AND user.idLocal=local.idLocal AND nom LIKE '%".$getRecherche."%' AND ann.idTypeAnnonce LIKE '".$getTypeAnnonce."' AND ann.idCat LIKE '".$getCategorie."' AND user.idLocal LIKE '".$getLocalisation."' ORDER BY reference";
		$result           = mysqli_query($select_db, $query);
		$row 			  = mysqli_fetch_assoc($result);
		$nbTotalAnnonce   = $row['nb_annonce'];

		if ($nbTotalAnnonce == 0) {
			echo "Aucunes annonces ne correspondent avec vos critères de recherche.";
		} else {

			$nbAnnonceParPage = 4;
			$nbTotalPage      = ceil($nbTotalAnnonce / $nbAnnonceParPage);

			if (isset($_GET['page'])) {
	    		$pageCourante = $_GET['page'];
			    if ($pageCourante > $nbTotalPage) {
	        		$pageCourante = $nbTotalPage;
	        		header('Location: recherche.php?q='.$getRecherche.'&typ='.$getTypeAnnonce.'&cat='.$getCategorie.'&loc='.$getLocalisation.'&page='.$pageCourante.'');
	    		}
			} else {
	    		$pageCourante = 1; 
			}

			$premiereEntree = ($pageCourante-1)*$nbAnnonceParPage;

			$query     = "SELECT reference,nom,prix,photo1,typ.descTypeAnnonce, local.descLocal FROM annonce ann, type_annonce typ, utilisateur user, localisation local WHERE ann.idTypeAnnonce=typ.idTypeAnnonce AND ann.pseudo=user.pseudo AND user.idLocal=local.idLocal AND nom LIKE '%".$getRecherche."%' AND ann.idTypeAnnonce LIKE '".$getTypeAnnonce."' AND ann.idCat LIKE '".$getCategorie."' AND user.idLocal LIKE '".$getLocalisation."' ORDER BY reference DESC LIMIT ".$premiereEntree.",".$nbAnnonceParPage."";
			$result    = mysqli_query($select_db, $query);

			while ($annonce = mysqli_fetch_assoc($result)) {

				$reference    = $annonce['reference'];
				$nomAnnonce   = $annonce['nom'];
				$photo1	 	  = $annonce['photo1'];
				$typeAnnonce  = $annonce['descTypeAnnonce'];
				$prix		  = $annonce['prix'];
				$localisation = $annonce['descLocal'];

				if ($typeAnnonce != "Vente") {
				echo '<div class="col-md-3">'."\n\t".'<div class="card mb-3 box-shadow">'."\n\t\t".' <img class="card-img-top" src="src/photos/'.$photo1.'" alt="Card image cap">'."\n\t\t".'<div class="card-body">'."\n\t\t\t".'<h5 style="color: #696969;"><strong>'.$nomAnnonce.'</strong> </h5>'."\n".'<p style="margin-top: -10px;"><small>'.$typeAnnonce.', '.$localisation.'</small></p>'."\n\t\t".'<div class="d-flex justify-content-between align-items-center">'."\n\t\t".'<div class="btn-group">'."\n\t\t\t".'<a role="button" href="annonce.php?ref='.$reference.'" class="btn btn-sm btn-outline-secondary">Voir</a>'."\n\t\t".'</div>'."\n\t\t".'</div></div></div></div>';
				} else {
					// à changer avec bon code html/css
					echo '<div class="col-md-3">'."\n\t".'<div class="card mb-3 box-shadow">'."\n\t\t".' <img class="card-img-top" src="src/photos/'.$photo1.'" alt="Card image cap">'."\n\t\t".'<div class="card-body">'."\n\t\t\t".'<h5 style="color: #696969;"><strong>'.$nomAnnonce.'</strong> </h5>'."\n".'<p style="margin-top: -10px;"><small>'.$typeAnnonce.', '.$localisation.'</small></p><p style="margin-top: -20px;"><small>'.$prix.' €</small></p>'."\n\t\t".'<div class="d-flex justify-content-between align-items-center">'."\n\t\t".'<div class="btn-group">'."\n\t\t\t".'<a role="button" href="annonce.php?ref='.$reference.'" class="btn btn-sm btn-outline-secondary">Voir</a>'."\n\t\t".'</div>'."\n\t\t".'</div></div></div></div>';
				}
			}

			echo "</div>";
		
			echo '<nav aria-label="Page navigation example"><ul class="pagination">';
			if ($nbTotalAnnonce <= $nbAnnonceParPage) {
				echo '<li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li><li class="page-item disabled"><a class="page-link" href="#">1/1</a></li><li class="page-item disabled"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
			} elseif ($pageCourante == 1) {
				$pageSuivante = $pageCourante+1;
				echo '<li class="page-item disabled"><a class="page-link " href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li><li class="page-item disabled"><a class="page-link" href="#">1/'.$nbTotalPage.'</a></li><li class="page-item"><a class="page-link" href="accueil.php?page='.$pageSuivante.'" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
			} elseif ($pageCourante > 1 && $pageCourante < $nbTotalPage) {
				$pageSuivante = $pageCourante+1;
				$pagePrecedente = $pageCourante-1;
				echo '<li class="page-item "><a class="page-link" href="accueil.php?page='.$pagePrecedente.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li><li class="page-item disabled"><a class="page-link" href="#">'.$pageCourante.'/'.$nbTotalPage.'</a></li><li class="page-item"><a class="page-link" href="accueil.php?page='.$pageSuivante.'" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
			} elseif ($pageCourante == $nbTotalPage) {
				$pagePrecedente = $pageCourante-1;
				echo '<li class="page-item "><a class="page-link" href="accueil.php?page='.$pagePrecedente.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li><li class="page-item disabled"><a class="page-link" href="#">'.$nbTotalPage.'/'.$nbTotalPage.'</a></li><li class="page-item disabled"><a class="page-link " href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
			}
			echo '</ul></nav>';
		}
	}

	function showOptions($table) {

		$select_db = connectDB();
		$query     = "SELECT * FROM ".$table." ORDER BY 2";
		$result    = mysqli_query($select_db, $query);

		switch ($table) {
    		case "categorie":
        		echo '<option selected disabled>Catégorie</option>';
        		break;
    		case "localisation":
        		echo '<option selected disabled>Localisation</option>';
        		break;
    		case "type_annonce":
        		echo '<option selected disabled>Type d\'annonce</option>';
        		break;
		}

		while ($options = mysqli_fetch_array($result)) {

			$id   = $options[0];
			$desc = $options[1];

			echo '<option value="'.$id.'">'.$desc.'</option>';

		}
	}

	// fonction identique à showOptions mais ajoute l'attribut "selected" à l'option concernée. cette fonction est utilisée pour la page de modification d'annonce.
	function showOptionsModify($table, $selected) {

		$select_db = connectDB();
		$query     = "SELECT * FROM ".$table." ORDER BY 2";
		$result    = mysqli_query($select_db, $query);

		switch ($table) {
    		case "categorie":
        		echo '<option selected disabled>Catégorie</option>';
        		break;
    		case "localisation":
        		echo '<option selected disabled>Localisation</option>';
        		break;
    		case "type_annonce":
        		echo '<option selected disabled>Type d\'annonce</option>';
        		break;
		}

		while ($options = mysqli_fetch_array($result)) {

			$id   = $options[0];
			$desc = $options[1];

			if ($id == $selected) {
				echo '<option value="'.$id.'" selected>'.$desc.'</option>';
			} else {
				echo '<option value="'.$id.'">'.$desc.'</option>';
			}

		}
	}

	

	// fonction pour modifier une annonce, elle ne touche pas aux photos
	/*function modAnnonce($reference, $titre, $typeAnnonce, $categorie, $description, $prix) {

		$select_db   = connectDB();
		// pour ajouter un anti-slash \ avant un caractère spécial
		$titre 		 = mysqli_real_escape_string($select_db, $titre);
		$description = mysqli_real_escape_string($select_db, $description);
		$query       = "UPDATE `annonce` SET `nom` = '".$titre."', `idTypeAnnonce` = '".$typeAnnonce."', `idCat` = '".$categorie."', `descriptif` = '".$description."', `prix` = ".$prix." WHERE `annonce`.`reference` = ".$reference.";";
		$result      = mysqli_query($select_db, $query);

		if ($result) {
			echo "Annonce modifiée dans la base de données.";
			header('Location: index.php');
		} else {
			echo "fail";
		}
	}*/

	function modAnnonce($reference, $donnees, $chmp) {
		$select_db   = connectDB();
		// pour ajouter un anti-slash \ avant un caractère spécial
		$titre 		 = mysqli_real_escape_string($select_db, $titre);
		$description = mysqli_real_escape_string($select_db, $description);
		switch ($chmp) {
			case 1 :
				$query       = "UPDATE `annonce` SET `nom` = '".$donnees."' WHERE `annonce`.`reference` = ".$reference.";";
				$result      = mysqli_query($select_db, $query);
				if ($result) {
					echo "Annonce modifiée dans la base de données.";
					header('Location: index.php');
				} else {
					echo "fail";
				}
				break;
			case 2 :
				$query       = "UPDATE `annonce` SET `idTypeAnnonce` = '".$donnees."' WHERE `annonce`.`reference` = ".$reference.";";
				$result      = mysqli_query($select_db, $query);
				if ($result) {
					echo "Annonce modifiée dans la base de données.";
					header('Location: index.php');
				} else {
					echo "fail";
				}
				break;
			case 3 :
				$query       = "UPDATE `annonce` SET `idCat` = '".$donnees."' WHERE `annonce`.`reference` = ".$reference.";";
				$result      = mysqli_query($select_db, $query);
				if ($result) {
					echo "Annonce modifiée dans la base de données.";
					header('Location: index.php');
				} else {
					echo "fail";
				}
				break;
			case 4 :
				$query       = "UPDATE `annonce` SET `descriptif` = '".$donnees."' WHERE `annonce`.`reference` = ".$reference.";";
				$result      = mysqli_query($select_db, $query);
				if ($result) {
					echo "Annonce modifiée dans la base de données.";
					header('Location: index.php');
				} else {
					echo "fail";
				}
				break;
			case 5 :
				$query       = "UPDATE `annonce` SET `prix` = '".$donnees."' WHERE `annonce`.`reference` = ".$reference.";";
				$result      = mysqli_query($select_db, $query);
				if ($result) {
					echo "Annonce modifiée dans la base de données.";
					header('Location: index.php');
				} else {
					echo "fail";
				}
				break;
			
			default:
				# code...
				break;
		}

	}

	// fonction pour changer une photo par une nouvelle
	// implique : suppresion de l'ancienne photo et upload de la nouvelle photo dans le serveur & mise à jour de la base de données
	function modPhoto($reference, $newPhoto, $oldPhoto, $number) {

		// suppresion de l'ancienne photo $oldPhoto
		unlink("../../src/photos/".$oldPhoto);
		// upload de la nouvelle photo dans le serveur & mise à jour de la base de données (colonne photo)
		UploadInsertPhoto($newPhoto, $reference, $number, "../");

	}

	// fonction pour supprimer la photo2 ou photo3 (selon $number)
	// implique : suppresion de la photo + mise à jour de la base de données
	function rmPhoto($reference, $photoToDel, $number) {

		// suppresion de la photo
		unlink("../../src/photos/".$photoToDel);
		// mise à jour de la base de données. Mise à NULL de la colonne photo concernée
		$select_db = connectDB();
		$query     = "UPDATE `annonce` SET `photo".$number."` = NULL WHERE `annonce`.`reference` = ".$reference."";
		mysqli_query($select_db, $query); 

	}

	// fonction pour récupérer la localisation de l'utilisateur
	function getUserLocalisation($pseudo) {

		$select_db = connectDB();
		$query     = "SELECT idLocal FROM utilisateur WHERE pseudo='".$pseudo."'";
		$result    = mysqli_query($select_db, $query);
		$user      = mysqli_fetch_assoc($result);
		$local     = $user['idLocal'];

		return $local;

	}

	function changeLocalisation($pseudo, $newLocalisation) {

		$select_db = connectDB();
		$query     = "UPDATE `utilisateur` SET `idLocal` = '".$newLocalisation."' WHERE `utilisateur`.`pseudo` = '".$pseudo."';";
		$result    = mysqli_query($select_db, $query);

		if ($result) {
			return true;
		} else {
			return false;
		}


	}
?>
