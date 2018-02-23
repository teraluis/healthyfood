<?php
require 'Controleur/controlleur.php';
$result="pas de resultat";
if(isset($_GET['recherche'])){
	$input = $_GET['recherche'];
	$result = rechercher($input,$bdd);
}
echo json_encode($result);
?>