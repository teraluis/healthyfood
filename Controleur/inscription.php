<?php
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
$donnees=array('nom'=>trim($nom),
    'prenom'=>trim($prenom),
    'naissance'=>$naissance,
    'sexe'=>$sexe,
    'email'=>$email,
    'password'=>trim($password),
    'pays'=>trim($pays),
    'region'=>trim($region),
    'city'=>trim($city),
    'zip'=>trim($zip));
$informations =array();
$new_user=new Utilisateur($bdd);
if($confirm==$password){
    $new_user->hydrate($donnees);
    $informations['password']="ok";
    $result=$new_user->inscriptionUtilisateur();
    if($result=="existe"){
        $informations['existe']=true;
    } else if($result=="inscrit") {
        $informations['inscrit']=true;
        $r=$new_user->lienConfirmation();
        if($r=="envoye"){
            $informations['mail']="envoye";
        }else if($r=="echec") {
            $informations['mail']="echec";
        }
    }
     
} else {
    $informations['password']=false; 
}
echo json_encode($informations);

