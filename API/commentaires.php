<?php
include '../connexion.php';
include '../header.php';
if(!empty($_POST['commentaire']) && !empty($_POST['id_recette']) && !empty($_POST['id_utilisateur'])){
    $nom=$_POST['nom'];
    $c=$_POST['commentaire'];
    $id_recette=$_POST['id_recette'];
    $id_user=$_POST['id_utilisateur'];
    $commentaire = new Commentaires($bdd);
    $commentaire->setIdRecette($id_recette);
    $commentaire->setIdUtilisateur($id_user);
    $commentaire->setCommentaires($c);
    $commentaire->ajouterCommentaire();
    echo $nom;
    
}
else {
    echo "error";
}