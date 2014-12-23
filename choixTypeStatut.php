<?php
session_start();
if(isset($_SESSION['admin']) && $_SESSION['admin']==true)
{
	$titre = $_POST['titre'];
	$type = $_POST['type'];
	$texte = $_POST['texte'];
	$datefin = $_POST['datefin'];
	$heurefin = $_POST['heurefin'];
	
	require 'params.php';
	mysql_connect($host,$user,$password) or die('Erreur de connexion au SGBD.');
	mysql_select_db($base) or die('La base de données n\'existe pas');
	$query="insert into statut(TYPE,TEXTE,DATEFIN,TITRE,HEUREFIN) VALUES('$type','$texte','$datefin','$titre','$heurefin')";
	mysql_query($query);
	mysql_close();
	header('location:Admin.php');
}
?>