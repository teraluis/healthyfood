<?php
class Recettes {
	private $db;
	private $nom;
        public $id;
        public $date_creation;
        public $ingredients= array();
        public $categorie;
        public $preparation;
        public $cuisson=0;// temps cuisson
        public $tpreparation=0;//temps preparation
        public $id_utilisateur;
        public $tpreparation_format="min"; // preparation minutes heures
        public $cuisson_format="min"; //cuisson minutes heures
        public $nombre_personnes;
        public $auteur;
        public $image="";
        public $url_video="";
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
        function getDb() {
            return $this->db;
        }

        function getNom() {
            return $this->nom;
        }

        function getId() {
            return $this->id;
        }

        function getDate_creation() {
            return $this->date_creation;
        }

        function getIngredients() {
            return $this->ingredients;
        }
        function setDb($db) {
            $this->db = $db;
        }

        function setNom($nom) {
            $this->nom = $nom;
        }

        function setId($id) {
            $this->id = $id;
        }

        function setDate_creation($date_creation) {
            $this->date_creation = $date_creation;
        }

        function setIngredients($ingredients) {
            $this->ingredients = $ingredients;
        }

        function setPreparation($preparation) {
            $this->preparation = $preparation;
        }

        function setCuisson($cuisson) {
            $this->cuisson = $cuisson;
        }
        function setCategorie($categorie){
            $this->categorie=$categorie;
        }

        function getCategorie() {
            return $this->categorie;
        }

        function getPreparation() {
            return $this->preparation;
        }

        function getCuisson() {
            return $this->cuisson;
        }
        
        public function getRecette($id){
            $recette = array();
            $sql="select * from recettes where id =".$id." ";
            $query = $this->db->query($sql)->fetch();
            $sql2="select count(*) from recettes where auteur='".$query['auteur']."' ";
            $query2= $this->db->query($sql2)->fetch();
            $sql3 ="select * from utilisateurs where prenom='".$query['auteur']."'";
            $query3= $this->db->query($sql3)->fetch();
            $sql4 = "select avg(etoiles) as etoiles_moy from etoiles where id_recette=".$id;
            $query4 = $this->db->query($sql4)->fetch();
            $sql5="select  utilisateurs.nom as nom,utilisateurs.prenom as prenom, etoiles.etoiles as etoiles from utilisateurs  join etoiles on utilisateurs.id=etoiles.id_utilisateur where etoiles.id_recette=".$id;
            $query5= $this->db->query($sql5)->fetchAll(); 
            $recette ['recette']= array('nbpersonnes' => $query['nbpersonnes'],'nom'=>$query['nom'],'nb_recettes' => $query2['count(*)'],
                'auteur' => $query['auteur'],'nom_auteur' => $query3['nom'], 'cuisson' => $query['cuisson'],'date'=>$query['date_creation'],
                'preparation' => $query['preparation'],'categorie' => $query['categorie'],
                'tpreparation' =>$query['tpreparation'],'preparation_unites'=>$query['preparation_unites'],
                'cuisson_unites' =>$query['cuisson_unites'],'etoiles' => $query4['etoiles_moy'],
                'url_image' => $query['url_image'],'url_video'=>$query['url_video']);
            $sql6 ="select * from composition where recettes=".$id;
            $query6 = $this->db->query($sql6)->fetchAll();
            
            foreach ($query6 as $q){
                $recette ['ingredients'][] = array('id' => $q['id'],'id_recettes' => $q['recettes'],'nom_ingredient' => $q['nom'],'quantite' => $q['quantite'],'unites' => $q['unites']);
            }
            if(empty($query5)){
                $recette ['users'][]=array('nom' => "personne",'prenom' => "personne",'etoiles' => "aucune note");
            }else {
                foreach ($query5 as $q){
                $recette ['users'][] = array('nom' => $q['nom'],'prenom' => $q['prenom'],'etoiles' => $q['etoiles']);
                }  
            }
            return $recette;
        }
        public function recettes(){
            $sql="select count(id) as quantite from recettes";
            $query = $this->db->query($sql)->fetch();
            return $query['quantite'];
        }
        public function setTpreparation($tpreparation) {
            $this->tpreparation = $tpreparation;
        }

        public function setId_utilisateur($id_utilisateur) {
            $this->id_utilisateur = intVal($id_utilisateur);
            
        }
        public function getTpreparation() {
            return $this->tpreparation;
        }

        public function getId_utilisateur() {
            return $this->id_utilisateur;
        }
        public function setTpreparation_format($tpreparation_format) {
            $this->tpreparation_format = $tpreparation_format;
        }

        public function getTpreparation_format() {
            return $this->tpreparation_format;
        }

        public function setCuisson_format($cuisson_format) {
            $this->cuisson_format = $cuisson_format;
        }
        public function setNombre_personnes($nombre_personnes) {
            $this->nombre_personnes = $nombre_personnes;
        }

        public function setAuteur($auteur) {
            $this->auteur = $auteur;
        }
        public function setImage($image) {
            $this->image = $image;
        }
        public function setUrl_video($url_video) {
            $this->url_video = $url_video;
        }
        public function getCuisson_format() {
            return $this->cuisson_format;
        }

        public function getNombre_personnes() {
            return $this->nombre_personnes;
        }

        public function getAuteur() {
            return $this->auteur;
        }

        public function getImage() {
            return $this->image;
        }

        public function getUrl_video() {
            return $this->url_video;
        }

        public function ajouterRecette(){
        $sql="INSERT INTO `recettes`(`id_utilisateur`, `nom`, `auteur`, `preparation`, `url_image`,";
        $sql.="`nbpersonnes`, `categorie`, `url_video`, `cuisson`, `tpreparation`, `preparation_unites`, `cuisson_unites`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ";
            try {
            $requette=$this->db->prepare($sql);
            
            $requette->bindparam(1,$this->id_utilisateur,PDO::PARAM_INT);
            $requette->bindparam(2,$this->nom,PDO::PARAM_STR);
            $requette->bindparam(3,$this->auteur,PDO::PARAM_STR);
            $requette->bindparam(4, $this->preparation,PDO::PARAM_STR);
            $requette->bindparam(5,$this->image,PDO::PARAM_STR);
            $requette->bindparam(6,$this->nombre_personnes,PDO::PARAM_INT);
            $requette->bindparam(7,$this->categorie,PDO::PARAM_STR);
            if($this->getUrl_video()==NULL){
                $this->setUrl_video("vide");
            }
            $requette->bindparam(8,$this->url_video,PDO::PARAM_STR);
            $requette->bindparam(9, $this->cuisson,PDO::PARAM_INT);
            $requette->bindparam(10, $this->tpreparation,PDO::PARAM_STR);
            $requette->bindparam(11, $this->tpreparation_format,PDO::PARAM_STR);
            $requette->bindparam(12, $this->cuisson_format,PDO::PARAM_STR);
            $requette->execute();
            
            $sql="select id from recettes where nom='".$this->getNom()."'";
            $query= $this->db->query($sql)->fetch();
            
            return $query['id'];
            } catch (PDOException $e){
                return $e->getMessage();
            }
        }
        public function updateRecette(){
            $sql="UPDATE recettes SET nom=:nom,";
            $sql.="preparation=:preparation,url_image=:url_image,";
            $sql.="nbpersonnes=:nbpersonnes,categorie=:categorie,";
            $sql.="url_video=:video,cuisson=:cuisson,";
            $sql.="tpreparation=:tpreparation,preparation_unites=:preparation_unites,";
            $sql.="cuisson_unites=:cuisson_unites WHERE id=:id";
            try{
                $requette= $this->db->prepare($sql);
                $requette->execute(array(
                    ":nom"=> $this->nom,
                    ":preparation"=> trim($this->preparation),
                    ":url_image"=> $this->image,
                    ":nbpersonnes"=> $this->nombre_personnes,
                    ":categorie"=> $this->categorie,
                    ":video"=> $this->url_video,
                    ":cuisson"=> $this->cuisson,
                    ":tpreparation"=> $this->tpreparation,
                    ":preparation_unites"=> $this->tpreparation_format,
                    ":cuisson_unites"=> $this->cuisson_format,
                    ":id"=> $this->id
                    ));
            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        }
}