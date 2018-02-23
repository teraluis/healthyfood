<?php
require 'Controleur/controlleur.php';
/*le nombre d'utilisateurs*/
function nbUtilisateurs(PDO $bdd){
    $sql="SELECT COUNT(*) FROM utilisateurs";
    $resultat=$bdd->query($sql)->fetch();
    return $resultat[0];
}
function nb_recettes_utilisateur(PDO $bdd,$id_user){
    $sql="select count(nom) from recettes where id_utilisateur=".$id_user;
    $resultat = $bdd->query($sql)->fetch();
    return $resultat[0];
}
function utilisateurs_actifs($bdd){
    $sql="select count(distinct id_utilisateur) from recettes";
    $resultat=$bdd->query($sql)->fetch();
    return $resultat[0];
}
function nb_plats($bdd,$categorie="plat principal"){
    $sql="select count(categorie) from recettes where categorie='".$categorie."'";
    $resultat=$bdd->query($sql)->fetch();
    return $resultat[0];
}
function nb_total_commentaires($bdd){
    $sql="select count(*) from commentaires";
    $resultat=$bdd->query($sql)->fetch();
    return $resultat[0];
}
function nb_mes_commentaires($bdd,$id){
    $sql="select count(*) from commentaires where id_utilisateur=".$id;
    $resultat=$bdd->query($sql)->fetch();
    return $resultat[0];
}
function moyenne_etoiles($bdd,$categorie){
    $sql="select AVG(etoiles.etoiles) from etoiles JOIN recettes ON recettes.id=etoiles.id_recette WHERE recettes.categorie='".$categorie."'";
    $resultat=$bdd->query($sql)->fetch();
    return round($resultat[0]);
}
function commentaires_quantites($bdd){
    $sql="select recettes.categorie as categorie, count(categorie)as quantite from commentaires JOIN recettes ON recettes.id=commentaires.id_recette group by categorie desc";
    $resultat=$bdd->query($sql)->fetchAll();

    for($i=0;$i<3;$i++){
        if(array_key_exists($i,$resultat)===false){
            $resultat[$i][0]="categorie manquante";  
            $resultat[$i][1]="zero";
        }
    }
    return $resultat;  
}
function affichage_utilisateurs($bdd){
    $sql="select count(recettes.id) as recettes,utilisateurs.id, utilisateurs.nom as nom,utilisateurs.prenom as prenom ,utilisateurs.email as email from utilisateurs LEFT JOIN recettes ON utilisateurs.id=recettes.id_utilisateur group by utilisateurs.email";
    $resultat=$bdd->query($sql)->fetchAll();
    return $resultat; 
}