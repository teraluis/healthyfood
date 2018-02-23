<?php
class Etoiles {
    private $id;
    private $id_recette;
    private $id_utilisateur;
    private $etoiles;
    private $bdd;
    public function __construct($bdd){
            $this->setDb($bdd);
            $bd=$bdd;
    }
    public function setDb($db){
            $this->bdd=$db;
    }
    public function setId($id){
        $this->id=$id;
    }
    public function setIdRecette($id_recette){
        $this->id_recette=$id_recette;
    }
    public function setIdUtilisateur($id_utilisateur){
        $this->id_utilisateur=$id_utilisateur;
    }
    public function setEtoiles($etoiles){
        $this->etoiles=$etoiles;
    }
    public function getId(){
        return $this->id;
    }
    public function getIdRecette(){
        return $this->id_recette;
    }
    public function getIdUtilisateur(){
        return $this->id_utilisateur;
    }
    public function getEtoiles(){
        return $this->etoiles;
    }
    public function afficherNotes(){
        $sql=" select recettes.nom as nom_recette,etoiles FROM etoiles join recettes on etoiles.id_recette=recettes.id";
        $requette = $this->bdd->query($sql);
        $requette->execute();
        $tab=array();
        if($requette->rowCount()===0){
            return $tab;
        }
        else {
            
            $resultats=$requette->fetchAll(PDO::FETCH_OBJ);
            foreach ($resultats as $resultat){
                $tab[]=array($resultat->nom_recette => $resultat->etoiles);
            }
        }
        return $tab;
    }
    public function afficherNotesPersonnes(){
        $id= $this->getIdRecette();
        $sql="SELECT recettes.nom as nom_recette,etoiles,utilisateurs.nom as nom_utilisateur FROM recettes JOIN etoiles    ON etoiles.id_recette = recettes.id JOIN utilisateurs    ON utilisateurs.id = etoiles.id_utilisateur where recettes.id=?";
        $requette = $this->bdd->prepare($sql);
        $requette->execute(array($id));
        $tab=array();
        $resultats=$requette->fetchAll(PDO::FETCH_OBJ);
        foreach ($resultats as $resultat){
            $tab[]=array($resultat->nom_utilisateur => $resultat->etoiles);
        }
        return $tab;
    }
    public function moyenne(){
        $requete = $this->bdd->prepare('SELECT AVG(etoiles) as moyenne FROM etoiles WHERE id_recette=:recette');
        $requete->execute(array(':recette'=> $this->getIdRecette()));
        $data=$requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();
        return round($data->moyenne,2);
    }
}

