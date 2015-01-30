<?php
	session_start();

	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$mail = $_POST['mail'];
	$groupe = $_POST['groupe'];
	$message = $_POST['message'];
	$date = date("d-m-Y");
	$heure = date("H:i");
	
	require 'params.php';
	mysql_connect($host,$user,$password) or die('Erreur de connexion au SGBD.');
	mysql_select_db($base) or die('La base de données n\'existe pas');
	$query="insert into message(NOM,PRENOM,MAIL,GROUPE,MESSAGE,DATEENVOI,HEUREENVOI) VALUES('$nom','$prenom','$mail','$groupe','$message','$date','$heure')";
	mysql_query($query);
	mysql_close();
	header('location:Contact.php');

?>