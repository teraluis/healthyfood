<?php
session_start();
require_once 'Controleur/controlleur.php';
if (isset($_SESSION['user_id'])) {
    $informations_utilisateur=informations_utilisateur($bdd,$_SESSION['user_id']);
    //var_dump($informations_utilisateur[0]['naissance']);
    include 'Vue/monCompte.php';
}
else{
	header('Location : index.php');
}
