<?php
class Commentaires {
    public $id;
    public $id_recette;
    public $id_utilisateur;
    public $commentaire;
    public $creation;
    public $updated;
    public $db;


    public function __construct(){
        
    }
    public function hydrate(array $donnees){
        foreach ($donnees as $key => $value)
        {
          // On récupère le nom du setter correspondant à l'attribut.
          $method = 'set'.ucfirst($key);

          // Si le setter correspondant existe.
          if (method_exists($this, $method))
          {
            // On appelle le setter.
            $this->$method($value);
          }
        }
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    public function getId_recette() {
        return $this->id_recette;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function getCommentaire() {
        return $this->commentaire;
    }

    public function getCreation() {
        return $this->creation;
    }

    public function getUpdated() {
        return $this->updated;
    }

    public function setId_recette($id_recette) {
        $this->id_recette = $id_recette;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
    }

    public function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;
    }

    public function setCreation($creation) {
        $this->creation = $creation;
    }

    public function setUpdated($updated) {
        $this->updated = $updated;
    }
    public function getDb() {
        return $this->db;
    }
    
    public function setDb($db) {
        $this->db = $db;
    }
    public static function afficherCommentaires(PDO $bdd,$id_recette){
        $sql ="select * from commentaires where id_recette=".$id_recette;
        $query = $bdd->query($sql)->fetchAll();
        $commentaires=array();
        if(!empty($query)){
        
            foreach ($query as $q){
                $sql2="select * from utilisateurs where id=".$q['id_utilisateur'];
                $query2=$bdd->query($sql2)->fetch();
                $commentaires['commentaires'][] = array('nom' =>$query2['nom'],'prenom' =>$query2['prenom'] ,'id' => $q['id'],'id_recette' => $q['id_recette'],
                    'id_utilisateur' => $q['id_utilisateur'],
                    'sexe' => $query2['sexe'],
                    'commentaire' => $q['commentaire'],
                    'creation' => $q['creation'],
                    'updated' => $q['updated']);
            }
        }else {
            $commentaires['commentaires']="pas de commentaires pour cette recette";
        }
        return $commentaires;
    }
}

