<?php
session_start();
require 'Controleur/controlleur.php';

if(isset($_SESSION['user_id'])){
    include 'Vue/ajouterRecette.php';
    if(isset($_POST['nom_recette']) && isset($_POST['auteur']) && isset($_POST['preparation']) && isset($_POST['url_image']) && isset($_POST['categorie'])){
	$nouvelle_recette = new Recettes($bdd);
	$recette =[
		'nom'=>$_POST['nom_recette'],
		'id_utilisateur'=>$_SESSION['user_id'],
		'categorie'=>$_POST['categorie'],
		'preparation'=>$_POST['preparation'],
		'tpreparation'=>$_POST['tpreparation'],
		'tpreparation_format'=>$_POST['format_preparation'],
		'cuisson'=>$_POST['temps_cuisson'],
		'cuisson_format'=>$_POST['format_cuisson'],
		'nombre_personnes'=>$_POST['nombre_personnes'],
	];
	echo($recette['nom']);
	}
}
else  {
	header('Location : index.php');
}
