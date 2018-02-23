<?php 
session_start();
require 'Controleur/controlleur.php';
if (isset($_SESSION['user_id'])) {
        $recettes1 = mesRecettes($bdd,$_SESSION['user_id']);
	include 'Vue/mesRecettes.php';
}
else{
	header('Location : index.php');
}
?>