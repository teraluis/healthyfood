<?php 
require 'Controleur/controlleur.php';
session_start();
if (isset($_GET['receta'])) {
    $nom_recette=$_GET['receta'];
    $recetas=afficherRecettes($bdd,$nom_recette);
} else if (isset($_GET['ingredients'])) {
    $recetas = afficherRecettesIngredient($bdd,$_GET['ingredients']);
}else if (isset ($_GET['id_auteur'])){
    $recetas = afficherRecettesId($bdd,$_GET['id_auteur']);
}
else{
	$recetas=afficherRecettes($bdd);
}

include 'Vue/recettes.php';
?>