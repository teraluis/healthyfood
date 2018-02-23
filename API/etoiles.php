<?php
include '../connexion.php';
if(!empty($_GET['etoiles']) && !empty($_GET['id_recette']) && !empty($_GET['id_utilisateur'])){
    extract($_GET);
    $etoiles=$_GET['etoiles'];
    $recettes=$_GET['id_recette'];
    $utilisateur=$_GET['id_utilisateur'];
    $req=$bdd->prepare('SELECT id FROM recettes where id=:id');
    $req->execute(array(':id'=>$recettes));
    if($req->rowCount()===0){
        $req->closeCursor();
        header("Location : article.php");
    }
    else {
        $req->closeCursor();
        $requete=$bdd->prepare('SELECT * FROM etoiles where id_recette=:id and id_utilisateur=:utilisateur');
        $requete->bindParam(':id',$recettes,PDO::PARAM_INT);
        $requete->bindParam(':utilisateur',$utilisateur,PDO::PARAM_INT);
        $requete->execute();
        $identifiants=$requete->fetch(PDO::FETCH_OBJ);
        $identifiant = $identifiants->id;
        
        $requete->closeCursor();
        if(!empty($identifiant)){
            $sql="DELETE FROM  etoiles WHERE id_recette=:recette and id_utilisateur=:utilisateur";
            $requete = $bdd->prepare($sql);
            $requete->bindParam(':recette',$recettes,PDO::PARAM_INT);
            $requete->bindParam(':utilisateur',$utilisateur,PDO::PARAM_INT);
            $requete->execute();
            $requete->closeCursor();
            $requete = $bdd->prepare('SELECT AVG(etoiles) as moyenne FROM etoiles WHERE id_recette=:recette');
            $requete->execute(array(':recette'=>$recettes));
            $data=$requete->fetch(PDO::FETCH_OBJ);
            $requete->closeCursor();
            
        }
        $sql="INSERT INTO etoiles (id_recette,id_utilisateur,etoiles) VALUES(:recette,:utilisateur,:etoiles)";
        $requete = $bdd->prepare($sql);
        $requete->bindParam(':recette',$recettes,PDO::PARAM_INT);
        $requete->bindParam(':utilisateur',$utilisateur,PDO::PARAM_INT);
        $requete->bindParam(':etoiles',$etoiles,PDO::PARAM_INT);
        $requete->execute();
        $requete->closeCursor();
        $requete = $bdd->prepare('SELECT AVG(etoiles) as moyenne FROM etoiles WHERE id_recette=:recette');
        $requete->execute(array(':recette'=>$recettes));
        $data=$requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();
        echo $data->moyenne;
    }
     
     
}
else {
    header("Location : index.php");
}
