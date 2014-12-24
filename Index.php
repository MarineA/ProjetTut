<?php
session_start();
if(isset($_SESSION['admin']) && $_SESSION['admin']==true)
	header('location:Admin.php');
	else header('location:Accueil.php');
?>