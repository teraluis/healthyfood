<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ingredients
 *
 * @author luism
 */
class Ingredients {
    public $db;
    public $id;
    public $nom;
    public $quantite=10;
    public $unites="g";
    public $id_recette;
    public function __construct(PDO $bdd){
        $this->setDb($bdd);
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

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getQuantite() {
        return $this->quantite;
    }

    public function getUnites() {
        return $this->unites;
    }

    public function setId($id) {
        $this->id = $id;
    }



    public function setNom($nom) {
        $this->nom = trim($nom);
    }

    public function setQuantite($quantite) {
        $this->quantite = $quantite;
    }

    public function setUnites($unites) {
        $this->unites = $unites;
    }
    public function getDb() {
        return $this->db;
    }

    public function setDb($db) {
        $this->db = $db;
    }
    public function getId_recette() {
        return $this->id_recette;
    }

    public function setId_recette($id_recette) {
        $this->id_recette = $id_recette;
    }

    public function insertIngredients(){
        try{
        $sql="INSERT INTO ";
        $sql.="composition ( `recettes`, `nom`, `quantite`, `unites`) VALUES (?,?,?,?)";
        $requette = $this->db->prepare($sql);
        $requette->bindparam(1,$this->id_recette,PDO::PARAM_INT);
        $requette->bindparam(2,$this->nom,PDO::PARAM_STR);
        $requette->bindparam(3,$this->quantite,PDO::PARAM_INT);
        $requette->bindparam(4,$this->unites,PDO::PARAM_STR);
        $requette->execute();
        return $sql."<br>".$this->id_recette.",".$this->nom." ".$this->quantite." ".$this->unites."<br>";
        //return $requette->rowCount() . " ingredients ajoutes avec success";
        }
        catch (PDOException $e){
            return $e->getMessage();
        }
    }
    public function updateIngredients(){
        $sql="UPDATE composition SET recettes=".$this->id_recette.", nom=".$this->db->quote($this->nom).",";
        $sql.="quantite=".$this->quantite.", unites=".$this->db->quote($this->unites)."";
        $sql.="WHERE id=".intval($this->id);

        try{
        $requette= $this->db->exec($sql);
        return $requette . " ingredients mis à jour";
        } catch (PDOException $e){
            return $e->getMessage();
        }
    }
    public function deleteIngredients($id){
        $sql="DELETE FROM composition where id=".$id;
        try{
            $requette = $this->db->exec($sql);
            return $requette." ingredients suprimes";
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
        public function rechercheIngredients($ingredients,$limit=10){
            if($limit=="infini"){
                $lim="";
            }else{
                $lim="LIMIT ".$limit;
            }
    
            $where ='';
            $params = array();
            foreach ($ingredients as $value) {
                if($where ==''){
                $where .=" nom LIKE ? ";
                }else{
                    $where .= " OR nom LIKE ? ";
                }
                $params['type'][] = PDO::PARAM_STR;
                $params['value'][] = $value;
            }
        
            $sql = "SELECT * FROM recettes WHERE id in (SELECT recettes FROM composition WHERE ".$where." ) ".$lim;
            $stmt = $this->db->prepare($sql);
            for($key=0; $key<count($params['type']); $key++) {
                $stmt->bindValue($key + 1, "%".$params['value'][$key]."%", $params['type'][$key]);
            }
            $stmt->execute();
            $rep = array();
            if($stmt->errorCode()!='00000'){
                return $stmt->errorCode();
            }
            while ($data = $stmt->fetch()) {
                $rep [] = array(
                    "id" => $data['id'],
                    "nom" => $data['nom'],
                    "auteur"=>$data['auteur'],
                    "date" =>$data['date_creation'],
                    "preparation"=>$data['preparation'],
                    "categorie"=>$data['categorie']
                );
            }
            if(empty($rep)){
                return "Il n'existe aucune recette pour ce melange d'ingredients";
            }
            return $rep;
        }
}
