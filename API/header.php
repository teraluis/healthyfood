<?php
header("Content-Type:application/json");
try
{	$host="localhost";
	$bdd = new PDO('mysql:host='.$host.';dbname=carnet;charset=utf8', 'root');
	$return["succes"]=true;
	$return["message"]="connexion à la bbd rehussie";
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
	$return["succes"]=false;
	$return["message"]="echec de connexion à la bbd ";
}
?>