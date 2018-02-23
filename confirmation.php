<?php
require_once 'Controleur/connexion.php';

if(isset($_GET['id']) && isset($_GET['password'])){
    $id=$_GET['id'];
    $password=$_GET['pasword'];
    $sql="select * from utilisateurs where id=".$id;
    $result = $bdd->query($sql)->fetch();
    if(empty($result['password'])==false){
        if(sha1($result)==$password){
            $sql="update utilisateurs set valide='oui' where id=".$id;
            $exec=$bdd->exec($sql);
            echo "<h1>votre mail a été valide </h1>";
            echo "<p> retourner au <a href='recettes.plusdoptions.com'>healtlyfood</a>";
        }
    }else {
        echo "<h1> Donnees incorectes</h1>";
    }
}
else {
    echo "<h1> Donnees manquantes</h1>";
}

