<?php
require_once '../Modele/Utilisateur.class.php';
require_once '../Controleur/connexion.php';
$message="email non saissi";
function validatemail($email,$bdd){
   $sql="select * from utilisateurs where email='".$email."'";
   $exec=$bdd->query($sql)->fetch();
 
   if($exec['id']!=NULL){
       return "existe";
   }else if($exec['id']==NULL){
       return "inexistant";
   }
}
if(isset($_POST['email'])){
    $message="email saissi,";
    $email=$_POST['email'];
    if(validatemail($email, $bdd)=="existe"){
        $envoimail = Utilisateur::envoideMail($email,$bdd);
        $message =" envoimail:".$envoimail." ";
        if($envoimail=="erreur"){
           $message="erreur d'envoi à ".$_POST['email']."."; 
        }else if($envoimail=="envoye"){
           $message="email envoyé à :".$_POST['email']." avec succés"; 
        }
        else if($envoimail=="inconnu") {
           $message=" le mail est inconnu";
        }else {
            $message="erreur inconnu";
        }
    }
    else {
        $message="le mail ".$_POST['email']." n'existe pas";
    }
}
echo $message;