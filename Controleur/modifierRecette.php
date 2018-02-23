<?php
session_start();
require 'connexion.php';
require '../Modele/Recettes.class.php';
require '../Modele/Ingredients.class.php';


$recette=array();
$ingredients=array();
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
    $recette['nom']=trim(strtolower($_POST['nom_recette']));
}
if ($prenom) {
    $recette['auteur']=$_SESSION['prenom'];
}
if($image){
    $recette['image']=trim($_POST['url_image']);
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

$resultat ="echec par monque de données";

isset($_POST['id_recette'])?$id_recette=$_POST['id_recette']:$resultat="pas de recette";
$recette_modifier= new Recettes($bdd);
$recette_modifier->hydrate($recette);
if($resultat!="pas de recette"){
    $resultat="Recette ajouté<br>";
$recette_modifier->setId($id_recette);
$resultat.= $recette_modifier->updateRecette();
$idingredients=$_POST['idingredients'];
$idingredients = explode(",", $idingredients);
$qingredients=count($idingredients);
    $obj_ing=[];
    for($i=0;$i<count($idingredients);$i++){
        $donnees=array('id'=>$idingredients[$i],'id_recette'=>$id_recette,'nom'=>trim(strtolower($ingredients['nom'][$i])),'quantite'=>$ingredients['quantite'][$i],'unites'=>trim(strtolower($ingredients['unites'][$i])));
        $tmp = new Ingredients($bdd);
        $tmp->hydrate($donnees);
        if($donnees['id']==''){
        $r=$tmp->insertIngredients();    
        }else{
        $r=$tmp->updateIngredients();
        }


        $resultat.="<br>".$r;
        $obj_ing[$i]=$tmp;
    }

    if(isset($_POST['supprimer'])) 
    {
        $sup = $_POST['supprimer'];
        foreach($sup as $s){
            $r=$tmp->deleteIngredients($s);
            $resultat.="<br>".$r;
        }
    }
}
echo "votre recette a été modifie";
