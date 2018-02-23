<?php
try
{
	$host="localhost";
	$dbname="carnet";
	$user="root";
	$bdd = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8',$user, '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
	echo "<h1>Probleme de connexion à la basse de données $dbname </h1>";
	echo "<h3>Informations utilisateur</h3>";
	echo "<ul>";
	echo "<li>hote :".$host."</h1>";
	echo "<li>database :".$dbname."</h1>";
	echo "<li>utilisateur :".$user."</h1>";
	echo "</ul>";
	echo "<p> Veuillez verifier vos informations de connexion </p>";
	die('code d\'Erreur : ' . $e->getMessage());
}
?>