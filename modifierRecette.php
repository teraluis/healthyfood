<?php 
session_start();
require 'Controleur/controlleur.php';
if (isset($_SESSION['user_id']) && isset($_GET['id_recette'])) {
        $id=$_GET['id_recette'];
        $s = serialize($id);
        $u = unserialize($s);
        file_put_contents('store', $s);
        $recettes1 = mesRecettes($bdd,$_SESSION['user_id']);
        $tab_recette = $recette->getRecette($id);
        //var_dump($tab_recette);
	include 'Vue/modifierRecette.php';
}
else{
	header('Location : index.php');
}

?>