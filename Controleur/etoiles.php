<?php
session_start();
require 'connexion.php';
$sql="delete from etoiles where etoiles is NULL";
$r=$bdd->prepare($sql);
$r->execute();
$r->closeCursor();
if(!empty($_GET['note']) && !empty($_GET['recette_id']) ){
    $note=strip_tags($_GET['note']);
    $recette_id=strip_tags($_GET['recette_id']);
    if( isset($_SESSION['user_id'])){
        $user_id=$_SESSION['user_id']; 
    }else if(!empty($_GET['user_id'])){
        $user_id=$_GET['user_id'];
    }else{
        echo "il manque l identifiant";
    }
    $req=$bdd->prepare('SELECT id FROM recettes where id=:id');
    $req->execute(array(':id'=>$recette_id));
    if($req->rowCount()===0){
        $req->closeCursor();
        echo 'recette inexistante';
    }else{
        $req->closeCursor();
        $requete=$bdd->prepare('SELECT etoiles.id as id FROM etoiles where id_recette=:id and id_utilisateur=:utilisateur');
        $requete->bindParam(':id',$recette_id,PDO::PARAM_INT);
        $requete->bindParam(':utilisateur',$user_id,PDO::PARAM_INT);
        $requete->execute();
        $identifiants=$requete->fetch();
        $identifiant = $identifiants['id'];
        
        if($identifiant !=''){
            
            $sql="DELETE FROM  etoiles WHERE id_recette=:recette and id_utilisateur=:utilisateur";
            $requete = $bdd->prepare($sql);
            $requete->bindParam(':recette',$recette_id,PDO::PARAM_INT);
            $requete->bindParam(':utilisateur',$user_id,PDO::PARAM_INT);
            $requete->execute();
            $requete->closeCursor();
        }
        $sql="INSERT INTO etoiles (id_recette,id_utilisateur,etoiles) VALUES(:recette,:utilisateur,:etoiles)";
        $requete = $bdd->prepare($sql);
        $requete->bindParam(':recette',$recette_id,PDO::PARAM_INT);
        $requete->bindParam(':utilisateur',$user_id,PDO::PARAM_INT);
        $requete->bindParam(':etoiles',$note,PDO::PARAM_INT);
        $requete->execute();
        $requete->closeCursor();
        $requete = $bdd->prepare('SELECT AVG(etoiles) as moyenne FROM etoiles WHERE id_recette=:recette');
        $requete->execute(array(':recette'=>$recette_id));
        $data=$requete->fetch();
        echo $data['moyenne'];
        $requete->closeCursor();
                
    }
}  
else {
    echo "il manque l id recette ou la note";
	//header('Location : index.php');
}
$sql="delete from etoiles where etoiles is NULL";
$r=$bdd->prepare($sql);
$r->execute();
$r->closeCursor();