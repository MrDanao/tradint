<?php
session_start();

// récupère les fonctions PHP
include '../../includes/functions.php';

if (!isLogged()) {
    header('Location: ../../accueil.php');
}

$reference = $_GET['ref'];

if (rmAnnonce($reference)) {
	header('Location: .');
}

?>