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
		$conn = mysqli_connect("127.0.0.1", "USERNAME", "MOTDEPASSE", "tradint");
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

	function showNewAnnonce() {

		$select_db = connectDB();
		$query     = "SELECT reference,nom,prix,photo1 FROM annonce ORDER BY reference;";
		$result    = mysqli_query($select_db, $query);

		while ($annonce = mysqli_fetch_assoc($result)) {
			echo '<p><img src="../src/photos/'.$annonce['photo1'].'"></br>id : '.$annonce['reference'].'</br>nom annonce : <a href="annonce.php?ref='.$annonce['reference'].'">'.$annonce['nom'].'</a></br>prix : '.$annonce['prix'].'€</p>'."\n\t";
		}

	}

	//fonction à revoir...
	//function showAnnonce($refAnnonce) {

		//$select_db = connectDB();
		//$query     = "SELECT DISTINCT ann.reference, ann.nom, ann.descriptif, ann.prix, ann.photo1, ann.pseudo, typ.descTypeAnnonce, cat.descCat FROM annonce ann, categorie cat, type_annonce typ WHERE ann.reference='".$refAnnonce."' ann.idTypeAnnonce=typ.idTypeAnnonce and ann.idCat=cat.idCat";
		//$result    = mysqli_query($select_db, $query);
		
		//$row       = mysqli_fetch_assoc($result);

		//$reference = $row['ann.reference'];
		//$nom	   = $row['ann.nom'];
		//$prix	   = $row['ann.prix'];
		//$photo1	   = $row['ann.photo1'];
		//$pseudo    = $row['ann.pseudo'];
		//$categorie = $row['cat.descCat'];
		//$typeAnnonce = $row['typ.descTypeAnnonce'];

		// echo $reference." ".$nom." ".$prix." ".$photo1." ".$pseudo." ".$categorie." ".$typeAnnonce;

	//}

?>