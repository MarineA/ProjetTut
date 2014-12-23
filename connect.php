<?php
session_start();
require'params.php';
$pseudo=$_POST['pseudo'];
$password=$_POST['password'];
if($adminPseudo==$pseudo && $adminPassword==$password)$_SESSION['admin']=true;
header('location:Index.php');
?>