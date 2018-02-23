<?php
session_start();
require_once '../Modele/Utilisateur.class.php';
require_once 'connexion.php';

$prenom = $_POST['prenom'];
$nom=$_POST['nom'];
$naissance=$_POST['naissance'];
$sexe=$_POST['sexe'];
$email=$_POST['email'];
$password=$_POST['password'];
$confirm=$_POST['confirm'];
$pays=$_POST['pays'];
$region=$_POST['region'];
$city=$_POST['city'];
$zip=$_POST['zip'];
$donnees=array('nom'=>$nom,
    'id'=>$_SESSION['user_id'],
    'prenom'=>$prenom,
    'naissance'=>$naissance,
    'sexe'=>$sexe,
    'email'=>$email,
    'password'=>$password,
    'pays'=>$pays,
    'region'=>$region,
    'city'=>$city,
    'zip'=>$zip);
$informations =array();
$new_user=new Utilisateur($bdd);
if($confirm==$password){
    $new_user->hydrate($donnees);
    $informations['password']="ok";
    $result=$new_user->updateUtilisateur();  
} else {
    $informations['password']=false; 
}
echo json_encode($informations);

