<?php
require 'connexion.php';
require '../Modele/Recettes.class.php';
require '../Modele/Ingredients.class.php';


$ingredients=isset($_POST['ingredients']);
$limite=isset($_POST['limite']);
$recettes = new Ingredients($bdd);
if($ingredients){
    if($limite){
        $tab=$recettes->rechercheIngredients($_POST['ingredients'],$_POST['limite']);
    }else{
        $tab=$recettes->rechercheIngredients($_POST['ingredients']);
    }
    //var_dump($tab);
    for($i=0;$i<count($tab);$i++){
        $echo[$i]=array($tab[$i]['nom'],$tab[$i]['auteur'],$tab[$i]['id']);
    }
  if($tab=="Il n'existe aucune recette pour ce melange d'ingredients"){
      echo "error";
  }else {
      echo json_encode($tab); 
  }

}else{
    echo "error";
}
?>