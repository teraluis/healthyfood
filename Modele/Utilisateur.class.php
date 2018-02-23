<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utilisateur
 *
 * @author luism
 */
class Utilisateur {
    private $db;
    private $id;
    private $nom;
    private $prenom;
    private $inscription;
    private $naissance;
    private $sexe;
    private $email;
    private $password;
    private $pays;
    private $region;
    private $city;
    private $zip;
    public function __construct($bdd){
            $this->setDb($bdd);
    }
    public function setDb($db){
            $this->db=$db;
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
    public function inscriptionUtilisateur(){
        // Vérification de la validité des informations
        $existence_utilisateur ="select count(id) from utilisateurs where email='". $this->email."'";
        $requete = $this->db->query($existence_utilisateur);
        $resultat=$requete->fetch();
        if($resultat[0]=='1'){
            return "existe";
        }
        else if($resultat[0]=='0'){
        // Insertion
        $req = $this->db->prepare('INSERT INTO utilisateurs(nom,prenom, password, email,inscription,sexe,pays,region,city,zip,valide,naissance) VALUES(:nom,:prenom, :pass, :email, NOW(),:sexe,:pays,:region,:city,:zip,"non",:naissance)');
        $req->execute(array(
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'pass' => $this->password,
            'email' => $this->email,
            'sexe'=> $this->sexe,
            'pays'=> $this->pays,
            'region'=> $this->region,
            'city'=> $this->city,
            'zip'=> $this->zip,
            'naissance'=> $this->naissance
            ));
        return "inscrit";
        }
    }
    public function listeUtilisateurs(){
        $tab="<table class=\"avectri\">";
        $tab.="<thead><tr><th>nom prenom </th><th>email</th><th>inscrit le</th></tr></thead>";
        $tab.="<tbody>";
        $sql ="select * from utilisateurs";
        foreach  ($this->db->query($sql) as $row) {
            $tab.="<tr><td>".$row['nom']." ".$row['prenom']."</td><td>".$row['email']."</td><td>".$row['inscription']."</td>";
        }
        $tab.="</tbody>";
        $tab.="</table>";
        return $tab;
    }
    public function connexionUtilisateur($email,$pasword){
        // Vérification des identifiants
        $req = $this->db->prepare('SELECT id,nom,prenom,inscription FROM utilisateurs WHERE email = :email AND password = :password');
        $req->execute(array(
            'email' => $email,
            'password' => $pasword));
            $resultat = $req->fetch();
        if (!$resultat)
        {
            return $resultat;
            
            header("Location:../mauvaispassword.php");
            return 'Mauvais identifiant ou mot de passe !';
            exit;   
        }
        else
        {   
           $this->setId($resultat['id']);
           $this->setNom($resultat['nom']);
           $this->setPrenom($resultat['prenom']);
           $this->setInscription($resultat['inscription']);
           $this->setId($resultat['id']);
           return $resultat['id'];
        }
    }
    public function setId($id){
        $this->id=$id;
    }
    public function setNom($nom){
        $this->nom=$nom;
    }
    public function setPrenom($prenom){
        $this->prenom=$prenom;
    }
    public function setInscription($inscription){
        $this->inscription=$inscription;
    }
    public function getNom(){
        return $this->nom;
    }
    public function getPrenom(){
        return $this->prenom;
    }
    public function getInscription(){
        return $this->inscription;
    }
    public function getId(){
        return $this->id;
    }
    public function getNaissance() {
        return $this->naissance;
    }

    public function getSexe() {
        return $this->sexe;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getPays() {
        return $this->pays;
    }

    public function getRegion() {
        return $this->region;
    }

    public function getCity() {
        return $this->city;
    }

    public function getZip() {
        return $this->zip;
    }

    public function setNaissance($naissance) {
        $this->naissance = $naissance;
    }

    public function setSexe($sexe) {
        $this->sexe = $sexe;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setPays($pays) {
        $this->pays = $pays;
    }

    public function setRegion($region) {
        $this->region = $region;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setZip($zip) {
        $this->zip = $zip;
    }

    public function updateUtilisateur(){
        $sql="update utilisateurs set nom=?,prenom=?,email=?,password=?,pays=?,city=?,zip=?,region=?,sexe=?,naissance=?  WHERE id= ? ";
        $requete = $this->db->prepare($sql);
        $requete->bindparam(1,$this->nom,PDO::PARAM_STR);
        $requete->bindparam(2,$this->prenom,PDO::PARAM_STR);
        $requete->bindparam(3,$this->email,PDO::PARAM_STR);
        $requete->bindparam(4,$this->password,PDO::PARAM_STR);
        $requete->bindparam(5,$this->pays,PDO::PARAM_STR);
        $requete->bindparam(6,$this->city,PDO::PARAM_STR);
        $requete->bindparam(7,$this->zip,PDO::PARAM_STR);
        $requete->bindparam(8,$this->region,PDO::PARAM_STR);
        $requete->bindparam(9,$this->sexe,PDO::PARAM_STR);
        $requete->bindparam(10,$this->naissance,PDO::PARAM_STR);
        $requete->bindparam(11,$this->id,PDO::PARAM_INT);
        $resultat = $requete->execute();
        $requete->closeCursor();
        return $resultat;
        
    }
    public function sautligne($mails){
        $mails_tab = explode(",",$mails);
        foreach ($mails_tab as $mail){
            if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
            {
                    $passage_ligne = "\r\n";
            }
            else
            {
                    $passage_ligne = "\n";
            }
        }
        return $passage_ligne;
    }
    public function lienConfirmation(){
        $message="";
        $message_html="";
        $boundary = "-----=".md5(rand());
        $req = $req = $this->db->prepare('SELECT * FROM utilisateurs WHERE email = :email');
        $req->execute(array(
            'email' => $this->email));
        $resultat = $req->fetch();
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#i", $resultat['email']))
        {
                $passage_ligne = "\r\n";
        }
        else
        {
                $passage_ligne = "\n";
        }
        $lien="http://recettes.plusdoptions.com/confirmation.php?id=".$resultat['id']."&password=".sha1($resultat['password']);
        $subjet ="Confirmer votre email";
        $html= file_get_contents("http://recettes.plusdoptions.com/Vue/lien_confirmation.html");
        $cible = array("%LIEN%","%PASSWORD%","%NOM%","%PRENOM%");
        $remplacer=array($lien,$resultat['password'],$resultat['nom'],$resultat['prenom']);
        $message_html=str_replace($cible, $remplacer, $html);
        $message=$passage_ligne."".$message_html."";
        $headers = 'From: plusdoptions@gmail.com' ."".$passage_ligne."".'Reply-To: luismanresaramirez@gmail.com' . "".$passage_ligne;
        $headers.= "MIME-Version: 1.0".$passage_ligne;
        $headers.= "Content-Type: text/html;charset=\"ISO-8859-1\"".$passage_ligne."boundary=\"$boundary\"".$passage_ligne; 
        $alors= mail($resultat['email'],$subjet,$message,$headers);
        if(!$alors){
            return "echec";
        }else {
            return "envoye";
        }
    }       
    public static function envoideMail($email,$bdd){
        $message="";
        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE email = :email');
        $req->execute(array(
            'email' => $email));
            $resultat = $req->fetch();
        if ($resultat['id']==NULL)
        {
            return "inconnu";
        }else{
            if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $resultat['email']))
            {
                    $passage_ligne = "\r\n";
            }
            else
            {
                    $passage_ligne = "\n";
            }
            //=====Création de la boundary
            $boundary = "-----=".md5(rand());
            $subjet ="healtly food mot de Passe oublie";
            $html = file_get_contents('http://recettes.plusdoptions.com/Vue/mail.html');
            $cible = array("%EMAIL%","%PASSWORD%","%NOM%","%PRENOM%");
            $remplacer=array($email,$resultat['password'],$resultat['nom'],$resultat['prenom']);
            $message_html=str_replace($cible, $remplacer, $html);
      
            $headers ="From: \"Admin\"<healthyfood@plusdoptions.com>".$passage_ligne;
            $headers.="Reply-to: \"Admin\" <luismanresaramirez@gmail.com>".$passage_ligne;
            $headers.= "MIME-Version: 1.0".$passage_ligne;
            $headers.= "Content-Type: text/html;charset=\"ISO-8859-1\"".$passage_ligne."boundary=\"$boundary\"".$passage_ligne; 
            
            $message.= $passage_ligne.$message_html.$passage_ligne;
            
            $alors= mail($resultat['email'],$subjet,$message,$headers);
            
            if(!$alors){
                return "erreur";
            }
            else {
                return "envoye";
            }
        }
    }
    public function recettes(){
        $sql="select count(id) as quantite from recettes where id_utilisateur=".$this->id;
        $query = $this->db->query($sql)->fetch();
        $nombre= $query['quantite'];
        return $nombre;
    }
    public function recettes_moyennes($user_id){
$sql="select recettes.id as id,recettes.url_image as image,recettes.categorie as categorie,recettes.date_creation as creation ,recettes.nom as nom,avg(etoiles.etoiles) as moyenne from etoiles join recettes on etoiles.id_recette=recettes.id where recettes.id_utilisateur=".$user_id." group by nom order by nom";
/*        $sql="select recettes.id as id_recette ,recettes.nom as nom_recette ,avg(etoiles.etoiles) as moyenne from recettes,etoiles where recettes.id_utilisateur=".$user_id." AND etoiles.id_recette=recettes.id";*/
        $query = $this->db->query($sql)->fetchAll();
        if($query){
        $tab=array();
            foreach ($query as  $q) {
                   $tab['recettes_moyenne'][]=array('id'=>$q['id'],
                    'image'=>$q['image'],
                    'categorie'=>$q['categorie'],
                    'creation'=>$q['creation'],
                    'nom'=>$q['nom'],'moyenne'=>$q['moyenne']);
            }             
        }
        else{
            $tab="vide";
        }
        return $tab; 
    }
    
}
