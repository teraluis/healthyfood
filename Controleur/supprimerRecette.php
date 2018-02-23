<?php
session_start();
require 'connexion.php';
require '../Modele/Recettes.class.php';
require '../Modele/Ingredients.class.php';

$message="";
if(isset($_POST['id']) && isset($_SESSION['user_id']) ){ 
    $id=$_POST['id'];
    $sql="delete from composition where recettes=".$id;
    $sql2="delete from recettes where id=".$id;
    $sup=$bdd->exec($sql);
    if($sup){
        $message.="suppression ingredients rehussie,";
    }
    else {
        $message.="echec de suppression d ingredients,";
    }
    $sup=$bdd->exec($sql2);
    if($sup){
        $message.="suppression recette rehussie,";
    }
    else {
        $message.="echec de suppression,";
    }
}
else{
    $message.="manque l'id";
}
echo $message;