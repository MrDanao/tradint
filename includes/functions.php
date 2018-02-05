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
		$conn = mysqli_connect("127.0.0.1", "dantran", "vitrygtr", "tradint");
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
		$result	                    = mysqli_query($select_db, $query);

		if ($result) {
			return true;
		} else {
			return false;
		}

	}

	// pour checker pseudo et mot de passe lors de la connexion
	function connectUser($pseudo, $passwd_clair) {

		// vérifie l'inexistance du pseudo
		if (!checkUserInexistance($pseudo)) {

			// si existant, on récupère le mot de passe hashé et le salt stockés dans la table 'utilisateur' de la base 'tradint'
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
		} else {
			return false;
		}

	}


	// pour lister les dernières annonces avec pagination, notamment utilisée dans la page d'accueil (accueil.php, ligne 32)
	function showNewAnnonce() {

		
		$select_db 		  = connectDB();
		$query    		  = "SELECT COUNT(*) AS nb_annonce FROM annonce";
		$result           = mysqli_query($select_db, $query);
		$row 			  = mysqli_fetch_assoc($result);
		$nbTotalAnnonce   = $row['nb_annonce'];
		$nbAnnonceParPage = 3;
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

		$query     = "SELECT reference,nom,prix,photo1,typ.descTypeAnnonce FROM annonce ann, type_annonce typ WHERE ann.idTypeAnnonce=typ.idTypeAnnonce ORDER BY reference DESC LIMIT ".$premiereEntree.",".$nbAnnonceParPage."";
		$result    = mysqli_query($select_db, $query);

		while ($annonce = mysqli_fetch_assoc($result)) {

			$reference   = $annonce['reference'];
			$nomAnnonce  = $annonce['nom'];
			$photo1	 	 = $annonce['photo1'];
			$typeAnnonce = $annonce['descTypeAnnonce'];
			$prix		 = $annonce['prix'];

			if ($typeAnnonce != "Vente") {
				echo '<p><img src="../src/photos/'.$photo1.'"></br><a href="annonce.php?ref='.$reference.'">'.$nomAnnonce.'</a></br>'.$typeAnnonce.'</p>'."\n\t";
			} else {
				// à changer avec bon code html/css
				echo '<p><img src="../src/photos/'.$photo1.'"></br><a href="annonce.php?ref='.$reference.'">'.$nomAnnonce.'</a></br>'.$typeAnnonce.' - '.$prix.'€</p>'."\n\t";
			}
		}

		// Listing des pages avec redirection
		echo '<p>Page : ';
		for ($i=1; $i<=$nbTotalPage; $i++) {
    		if($i==$pageCourante) {
        		echo ' [ '.$i.' ] '; 
    		} else {
        		echo ' <a href="accueil.php?page='.$i.'">'.$i.'</a> ';
    		}
		}
		echo '</p>';

	}

	// pour afficher l'annonce (appelé dans le fichier annonce.php, ligne 33)
	function showAnnonce($refAnnonce) {

		$select_db   = connectDB();
		$query       = "SELECT DISTINCT ann.reference, ann.nom, ann.descriptif, ann.prix, ann.photo1, ann.pseudo, typ.descTypeAnnonce, cat.descCat FROM annonce ann, categorie cat, type_annonce typ WHERE ann.reference='".$refAnnonce."' and ann.idTypeAnnonce=typ.idTypeAnnonce and ann.idCat=cat.idCat";
		$result      = mysqli_query($select_db, $query);
		$row         = mysqli_fetch_assoc($result);

		// récupération des données propres à l'annonce
		$reference   = $row['reference'];
		$nomAnnonce  = $row['nom'];
		$prix	     = $row['prix'];
		$photo1	     = $row['photo1'];
		$pseudo      = $row['pseudo'];
		$categorie   = $row['descCat'];
		$typeAnnonce = $row['descTypeAnnonce'];
		$descriptif  = $row['descriptif'];

		// à changer avec bon code html/css
		echo $nomAnnonce."</br>";
		echo '<img src="src/photos/'.$photo1.'"></br>';
		echo $typeAnnonce." - ".$prix."€</br>";
		echo $descriptif;

	}

	function isPhoto($photo) {

		if ($photo == 'NULL') {
			return $photo;
		} else {
			return "'".$photo['name']."'";
		}

	}

	function UploadInsertPhoto($photo, $id, $number) {

		$tmpPathFile = $photo['tmp_name'];
        $tmpMimeFile = $photo['type'];
            		
        switch ($tmpMimeFile) {
        	
        	case 'image/jpeg':
          		$file_destination = '../src/photos/'.$id.'_p'.$number.'.jpg';
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
          		$file_destination = '../src/photos/'.$id.'_p'.$number.'.png';
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
					if (UploadInsertPhoto($photo_to_up, $id, $number)) {
						echo 'La photo '.$number.' a été ajoutée.';
					} else {
						echo 'La photo '.$number.' n\'a pas été ajoutée.';
					}
					$number++;
				}
			} 

		} else {
			echo "fail";
		}


	}

?>