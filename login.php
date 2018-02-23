<?php
require 'Controleur/controlleur.php';
$connexion ="";
if(isset($_POST['email']) && isset($_POST['password'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $user=connexionUtilisateur($email,$password,$bdd);
    if(empty($user)){
        echo "Failed";
    }else {
        session_start();
        $_SESSION['user_id']=$user['id'];
        $_SESSION['nom']=$user['nom'];
        $_SESSION['prenom']=$user['prenom'];
        $_SESSION['inscription']=$user['inscription'];
        $_SESSION['password']=$user['password'];
        $_SESSION['sexe']=$user['sexe'];
        $_SESSION['email']=$user['email'];
        echo implode(",",$user);
        $recette = [
        'id'=>$_SESSION['user_id'],
        'nom'=>$_SESSION['nom'],
        'prenom'=>$_SESSION['prenom'],
        'inscription'=>$_SESSION['inscription'],
        'sexe'=>$_SESSION['sexe'],
        'email'=>$_SESSION['email'],
        ];
        $utilisateur = new Utilisateur($bdd);
        $utilisateur->hydrate($recette);
        $_SESSION['recettes_utilisateur']=$utilisateur->recettes();
        $_SESSION['recettes_moyennes']=$utilisateur->recettes_moyennes($user['id']);
        if(isset($_POST['memoriser']) && $_POST['memoriser']=="oui"){
        $cookie_email =$user['email'];
        $cookie_password = $user['password'];
        setcookie("email",$cookie_email, time() + (24*60*60*30*12), "/"); 
        setcookie("password",$cookie_password, time() + (24*60*60*30*12), "/");
            echo ",memorise,conecte";
        }else{
            echo ",conecte";
        }
    }
}

