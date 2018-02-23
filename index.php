<?php
session_start();
require 'Controleur/controlleur.php';
try {
    if(isset($_SESSION['id'])){
        $id=$_SESSION['id'];
    }
    else if(isset ($_GET['id'])) {
       $id=$_GET['id'];
    }else{
       $id= dernierId($bdd);
    }
} catch (Exception $ex) {
    erreur($e->getMessage($ex));
}



$tab_recette = $recette->getRecette($id);
$commentaires = Commentaires::afficherCommentaires($bdd,$id);
include 'Vue/accueil.php';