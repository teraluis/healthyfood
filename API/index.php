<?php

include '../Modele/Recettes.class.php';
include '../Controleur/connexion.php';
if(!empty($_POST['id_recette'])){
    $id = $_POST['id_recette'];
    $recettes= new Recettes($bdd);
    $return  = $recettes->getRecettes($id);

}
else {
     $return=["id"=>"inexistant"];
}
	$results=$requete->fetchAll();
	$return["quantite"]=count($results);
	
	$return["recettes"]=$results;


echo json_encode($return);
