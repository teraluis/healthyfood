<?php
include_once 'header.php';
header('Content-type: text/html; charset=UFT-8');
if(isset($_POST['email']) && isset($_POST['password'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $_SESSION['id']=$utilisateur->connexionUtilisateur($email,$password);
    $_SESSION['id']=$utilisateur->getId();
    $_SESSION['nom']=$utilisateur->getNom();
    $_SESSION['prenom']=$utilisateur->getPrenom();
    $_SESSION['email']=$_POST['email'];
    $_SESSION['password']=$_POST['password'];
    $_SESSION['inscription']=$utilisateur->getInscription();
}
else if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['remember-me'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $_SESSION['id']=$utilisateur->connexionUtilisateur($email,$password);
    $_SESSION['nom']=$utilisateur->getNom();
    $_SESSION['prenom']=$utilisateur->getPrenom();
    $_SESSION['email']=$_POST['email'];
    $_SESSION['password']=$_POST['password'];
    $_SESSION['inscription']=$utilisateur->getInscription();
    setcookie('email', $_POST['email'], time() + 365*24*3600);
    setcookie('password', $_POST['password'], time() + 365*24*3600);
}
else if(!isset($_SESSION['email']) && !isset($_SESSION['password'])){
    echo "vous devez saissir vos identifiants";
    header("Location:../index.php");    
    exit;
}


?>
<!DOCTYPE html>
<html>
<?php include_once 'head.php';?>
<body>
<?php 
function fichier_courent(){
	$file = explode("\\",__FILE__);
	return $file[count($file)-1];
}
include_once 'navbar.php';
include_once 'article.php';
?>
<canvas id='canvas'></canvas>
<?php 
include 'footer.php';
?>
</body>
</html>