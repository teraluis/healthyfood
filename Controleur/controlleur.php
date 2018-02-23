<?php
require 'Controleur/connexion.php';
require 'Modele/Recettes.class.php';
require 'Modele/Ingredients.class.php';
require 'Modele/Utilisateur.class.php';
require 'Modele/Commentaires.class.php';
setlocale(LC_TIME, 'fra_fra');
$recette = new Recettes($bdd);
$_SESSION['total_recettes']=$recette->recettes();
function dernierId(PDO $bdd){ 
    $sql="select id from recettes order by id desc LIMIT 1";
    $query = $bdd->query($sql)->fetch();
    return $query['id'];
}
function touts_les_ingredients($bdd){
    $sql="SELECT  nom FROM `composition` group by nom order by nom asc";
    $r=$bdd->query($sql)->fetchAll();
    return $r;
}
function touts_les_unites($bdd){
    $sql="SELECT  distinct unites FROM `composition` group by nom order by unites asc";
    $r=$bdd->query($sql)->fetchAll();
    return $r;
}
function connexionUtilisateur($email,$password,$bdd){
    $sql ="select * from utilisateurs where email= '".htmlspecialchars($email)."' AND password='".$password."'  ";
    $query = $bdd->query($sql)->fetch();
    $donnees=array();
    if(!empty($query)){
    $donnees = array('id'=>$query['id'],
        'nom'=>$query['nom'],
        'prenom'=>$query['prenom'],
        'inscription'=>$query['inscription'],
        'password'=>$query['password'],
        'sexe'=>$query['sexe'],
        'email'=>$query['email']);
    }
    return $donnees;
}
function informations_utilisateur($bdd,$id_utilisateur){
    $sql="select * from utilisateurs where id=".$id_utilisateur."";
    $rs=$bdd->query($sql)->fetchAll();
    return $rs;
}
function ajouterCommentaire($id_recette,$id_utilisateur,$commentaire,$bdd){
    $sql="INSERT INTO commentaires(id_recette,id_utilisateur,commentaire) ";
    $sql.=" VALUES (?,?,?) ";
    $query = $bdd->prepare($sql);
    $id_recette = intval($id_recette);
    $id_utilisateur = intval($id_utilisateur);
    $query->bindparam(1,$id_recette,PDO::PARAM_INT);
    $query->bindparam(2,$id_utilisateur,PDO::PARAM_INT);
    $query->bindparam(3,$commentaire,PDO::PARAM_STR);
    $query->execute();
    $query->closeCursor();
}
function supprimerCommentaire($id_recette,$id_utilisateur,$bdd){
    $sql="delete from commentaires where id_recette=".$id_recette." AND id_utilisateur=".$id_utilisateur;
    $query = $bdd->execute($sql);
}
function mesRecettes($bdd,$user_id){
    $sql="select * from recettes where id_utilisateur=".$user_id;
    $query = $bdd->query($sql)->fetchAll();
    $recettes=array();
    foreach($query as $q){
        $recettes [] =array('id'=>$q['id'], 'nom'=>$q['nom'],'categorie'=>$q['categorie'],'image'=>$q['url_image']);
    }
    return $recettes;
}
function afficherRecettes($bdd,$nom=NULL){
    $sql="select recettes.id as id, recettes.categorie as categorie, recettes.nom as nom,";
    $sql.="recettes.auteur as auteur,recettes.url_image,DATE_FORMAT(recettes.date_creation, '%M') as mois,DATE_FORMAT(recettes.date_creation, '%d') as jour,DATE_FORMAT(recettes.date_creation, '%Y') as year,utilisateurs.nom as nom_user from recettes,utilisateurs where recettes.id_utilisateur=utilisateurs.id ";  
    if($nom!=NULL){
      $sql.="AND recettes.nom Like '".htmlspecialchars($nom)."'";
    }
    $query = $bdd->query($sql);
    $tab=array();
    if($query->rowCount()==0){
        $tab="aucune recette actuelement";
    }
    else{
        foreach($query as $q){
            $tab['recettes'][]=array(
                'id'=>$q['id'],
                'nom_recette'=>$q['nom'],
                'prenom'=>$q['auteur'],
                'image'=>$q['url_image'],
                'mois'=>$q['mois'],
                'nom_user'=>$q['nom_user'],
                'categorie'=>$q['categorie'],
                'year'=>$q['year'],
                'jour'=>$q['jour']);
        }
    }
    return $tab;
}
function afficherRecettesId($bdd,$id=NULL){
    $sql="select recettes.id as id, recettes.categorie as categorie, recettes.nom as nom,";
    $sql.="recettes.auteur as auteur,recettes.url_image,DATE_FORMAT(recettes.date_creation, '%M') as mois,DATE_FORMAT(recettes.date_creation, '%d') as jour,DATE_FORMAT(recettes.date_creation, '%Y') as year,utilisateurs.nom as nom_user from recettes,utilisateurs where recettes.id_utilisateur=utilisateurs.id ";  
    if($id!=NULL){
      $sql.="AND utilisateurs.id='".htmlspecialchars($id)."'";
    }
    $query = $bdd->query($sql);
    $tab=array();
    if($query->rowCount()==0){
        $tab="aucune recette actuelement";
    }
    else{
        foreach($query as $q){
            $tab['recettes'][]=array(
                'id'=>$q['id'],
                'nom_recette'=>$q['nom'],
                'prenom'=>$q['auteur'],
                'image'=>$q['url_image'],
                'mois'=>$q['mois'],
                'nom_user'=>$q['nom_user'],
                'categorie'=>$q['categorie'],
                'year'=>$q['year'],
                'jour'=>$q['jour']);
        }
    }
    return $tab;
}
function afficherRecettesIngredient($bdd,$ingredient=NULL){
    $sql="select recettes.id as id, recettes.categorie as categorie, recettes.nom as nom,";
    $sql.="recettes.auteur as auteur,recettes.url_image,DATE_FORMAT(recettes.date_creation, '%M') as mois,";
    $sql.= "DATE_FORMAT(recettes.date_creation, '%d') as jour,DATE_FORMAT(recettes.date_creation, '%Y') as year,";
    $sql.= "utilisateurs.nom as nom_user ";
    $sql.="from recettes,utilisateurs,composition where recettes.id=composition.recettes";
    $sql.=" ";
    if($ingredient!=NULL){
      $sql.=" AND composition.nom='".htmlspecialchars($ingredient)."'";
      $sql.=" AND utilisateurs.id=recettes.id_utilisateur";
    }
    $query = $bdd->query($sql);
    $tab=array();
    if($query->rowCount()==0){
        $tab="aucune recette actuelement";
    }
    else{
        foreach($query as $q){
            $tab['recettes'][]=array(
                'id'=>$q['id'],
                'nom_recette'=>$q['nom'],
                'prenom'=>$q['auteur'],
                'image'=>$q['url_image'],
                'mois'=>$q['mois'],
                'nom_user'=>$q['nom_user'],
                'categorie'=>$q['categorie'],
                'year'=>$q['year'],
                'jour'=>$q['jour']);
        }
    }
    return $tab;
}
function rechercher($input,$bdd){
    $result=array();
    $string="";
    $sql="SELECT nom,auteur from recettes where nom LIKE '%".htmlspecialchars($input)."%' LIMIT 10";
    $query=$bdd->query($sql)->fetchAll();
    
    if(!empty($query)){
        foreach($query as $q){
            $result[]=array('nom'=>$q['nom'],'auteur'=>$q['auteur']);
        }
    }
    else {
        $result[]="pas de sugestion";
    }
    return $result;
}
function afficher_etoiles($etoiles){
    $etoiles=round($etoiles);
            switch ($etoiles) {
          case "1":
            ?>
            <a  class="etoiles"  style="color: #aaa;">★</a><!--
        --><a  class="etoiles"   style="color: #aaa;">★</a><!-- 
        --><a  class="etoiles"   style="color: #aaa">★</a><!--
        --><a  class="etoiles"   style="color: #aaa">★</a><!-- 
        --><a  class="etoiles"   style="color: orange">★</a>
            <?php
            break;
          case "2":
            ?>
            <a  class="etoiles"  style="color: #aaa;">★</a><!--
        --><a  class="etoiles"   style="color: #aaa;">★</a><!-- 
        --><a  class="etoiles"   style="color: #aaa">★</a><!--
        --><a  class="etoiles"   style="color: orange">★</a><!-- 
        --><a  class="etoiles"   style="color: orange">★</a>
            <?php
            break;
          case "3":
            ?>
            <a  class="etoiles"  style="color: #aaa;">★</a><!--
        --><a  class="etoiles"   style="color: #aaa;">★</a><!-- 
        --><a  class="etoiles"   style="color: orange">★</a><!--
        --><a  class="etoiles"   style="color: orange">★</a><!-- 
        --><a  class="etoiles"   style="color: orange">★</a>
            <?php
            break;             
          case "4":
            ?>
            <a  class="etoiles"  style="color: #aaa;">★</a><!--
        --><a  class="etoiles"   style="color: orange;">★</a><!-- 
        --><a  class="etoiles"   style="color: orange">★</a><!--
        --><a  class="etoiles"   style="color: orange">★</a><!-- 
        --><a  class="etoiles"   style="color: orange">★</a>
            <?php
            break;                       
          case "5":
            ?>
            <a  class="etoiles"  style="color: orange;">★</a><!--
        --><a  class="etoiles"   style="color: orange;">★</a><!-- 
        --><a  class="etoiles"   style="color: orange">★</a><!--
        --><a  class="etoiles"   style="color: orange">★</a><!-- 
        --><a  class="etoiles"   style="color: orange">★</a>
            <?php
            break;          
          default:
            ?>
            <a  class="etoiles" style="color: #aaa;">★</a><!--
        --><a  class="etoiles" style="color: #aaa;">★</a><!-- 
        --><a  class="etoiles"   style="color: orange">★</a><!--
        --><a  class="etoiles"   style="color: orange">★</a><!-- 
        --><a  class="etoiles"   style="color: orange">★</a>
        <?php
            break;
        }
        
}
function afficher_petites_etoiles($etoiles){
    $return="";
    switch ($etoiles) {
        case '1':
            $return="&#9733;";
            break;
        case '2':
            $return="&#9733;&#9733;";
            break;
        case '3':
            $return="&#9733;&#9733;&#9733;";
            break;
        case '4':
            $return="&#9733;&#9733;&#9733;&#9733;";
            break;
        case '5':
            $return="&#9733;&#9733;&#9733;&#9733;&#9733;";
            break;                                           
        default:
            $return="pas de note pour l'instant";
            break;
    }
    return $return;
}
