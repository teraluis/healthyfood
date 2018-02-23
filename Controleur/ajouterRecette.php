<?php
session_start();
require 'connexion.php';
require '../Modele/Recettes.class.php';
require '../Modele/Ingredients.class.php';

$recette=array();
$ingredients=array();
$id_utilisateur=isset($_SESSION['user_id']);
$nom_recette=isset($_POST['nom_recette']);
$prenom=isset($_SESSION['prenom']);
$image=isset($_POST['url_image']);
$etape=isset($_POST['etape']);
$categorie=isset($_POST['type_plat']);
//preparation
$fpreparation =isset($_POST['format_preparation']);
$tpreparation = isset($_POST['temps_preparation']);
//cuisson
$fcuisson=isset($_POST['format_cuisson']);
$tcuisson=isset($_POST['temps_cuisson']);
//video
isset($_POST['url_video'])?$recette['url_video']=$_POST['url_video']:$recette['url_video']="";
//nbpersonnes
isset($_POST['nombre_personnes'])?$recette['nombre_personnes']=$_POST['nombre_personnes']:$recette['nombre_personnes']=6;
//ingredients
isset($_POST['ingredients'])?$ingredients['nom']=$_POST['ingredients']:$ingredients['ingredients']="eau";
//quantite
isset($_POST['quantite'])?$ingredients['quantite']=$_POST['quantite']:$ingredients['quantite']=1;
//unites
isset($_POST['unites'])?$ingredients['unites']=$_POST['unites']:$ingredients['unites']="litre";
if($id_utilisateur){        
    $recette['id_utilisateur']=$_SESSION['user_id'];       
}
if($nom_recette){   
    $recette['nom']=$_POST['nom_recette'];
}
if ($prenom) {
    $recette['auteur']=$_SESSION['prenom'];
}
if($image){
    $recette['image']=$_POST['url_image'];
}
if($etape){
	$recette['preparation']=$_POST['etape'];
}
if($categorie){
    $recette['categorie']= $_POST['type_plat'];
        
}
if($fpreparation){
    $recette['tpreparation_format']=$_POST['format_preparation'];
}
if($tpreparation){
	$recette['tpreparation']=$_POST['temps_preparation'];
}
if($fcuisson){
	$recette['cuisson_format']=$_POST['format_cuisson'];
}
if($tcuisson){
	$recette['cuisson']=$_POST['temps_cuisson'];
}
  


$nv_recette = new Recettes($bdd);
$nv_recette->hydrate($recette);
$id_recette2=$nv_recette->ajouterRecette();
$message="une erreur s'est malheuresement produit votre recette n'a pu être ajoutée";
if(preg_match("/^[0-9]/",$id_utilisateur)==1){
    $obj_ing=[];
    for($i=0;$i<count($ingredients['nom']);$i++){
        $donnees=array('id_recette'=>$id_recette2,'nom'=>trim(strtolower($ingredients['nom'][$i])),'quantite'=>$ingredients['quantite'][$i],'unites'=>trim(strtolower($ingredients['unites'][$i])));
        $tmp = new Ingredients($bdd);
        $tmp->hydrate($donnees);
        $tmp->insertIngredients();
        $obj_ing[$i]=$tmp;
    }
    $message="votre recette a été ajouté";
}
else {
    $message="error";
}
echo $message;