<?php
session_start();

// récupère les fonctions PHP
include '../../includes/functions.php';

if (!isLogged()) {
    header('Location: ../../accueil.php');
}

$pseudo    = $_SESSION['pseudo'];
$reference = $_GET['ref'];

if (rmAnnonce($pseudo, $reference)) {
	header('Location: .');
} else {
	echo "ERROR";
	sleep(2);
	header('Location: .');
}

?>