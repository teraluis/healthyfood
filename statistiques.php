<?php 
session_start();
require 'Controleur/statistiques.php';
if (isset($_SESSION['user_id'])) {
        $recettes1 = mesRecettes($bdd,$_SESSION['user_id']);
        $nb_users= nbUtilisateurs($bdd);
        $nb_recettes_users=nb_recettes_utilisateur($bdd,$_SESSION['user_id']);
        $actifs = utilisateurs_actifs($bdd);
        $principal=nb_plats($bdd);
        $dessert=nb_plats($bdd,"dessert");
        $cocktail=nb_plats($bdd,"cocktail");
        $commentaires_total = nb_total_commentaires($bdd);
        $commentaires_utilisateur= nb_mes_commentaires($bdd,$_SESSION['user_id']);
        $moy_plats=moyenne_etoiles($bdd,"plat principal");
        $moy_desserts= moyenne_etoiles($bdd, "dessert");
        $moy_cocktails=moyenne_etoiles($bdd, "cocktails");
        $nb_comment = commentaires_quantites($bdd);
        $affichage_utilisateurs=affichage_utilisateurs($bdd);
	include 'Vue/statistiques.php';
}
else{
	header('Location : index.php');
}
?>