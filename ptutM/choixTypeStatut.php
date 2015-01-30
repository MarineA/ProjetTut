<?php
session_start();
if(isset($_SESSION['admin']) && $_SESSION['admin']==true)
{
	$titre = $_POST['titre'];
	$type = $_POST['type'];
	$texte = $_POST['texte']; 
	$datedebut = $_POST['jourdebut'].'-'.$_POST['moisdebut'].'-'.$_POST['anneedebut'];
	$datefin = $_POST['jourfin'].'-'.$_POST['moisfin'].'-'.$_POST['anneefin'];
	$heuredebut= $_POST['heuredebut'].':'.$_POST['minutedebut'];
	$heurefin= $_POST['heurefin'].':'.$_POST['minutefin'];
	
	require 'params2.php';
	mysql_connect($host,$user,$password) or die('Erreur de connexion au SGBD.');
	mysql_select_db($base) or die('La base de données n\'existe pas');
	$query="insert into statut(TYPE,TITRE,TEXTE,DATEDEBUT,HEUREDEBUT,DATEFIN,HEUREFIN) VALUES('$type','$titre','$texte','$datedebut','$heuredebut','$datefin','$heurefin')";
	mysql_query($query);
	mysql_close();
	header('location:Admin.php');
}
?>