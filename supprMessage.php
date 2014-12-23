<?php
session_start();
if(isset($_SESSION['admin']) && $_SESSION['admin']==true)
{
$id=$_GET['id'];
require 'params.php';
mysql_connect($host,$user,$password) or die('Erreur de connexion au SGBD.');
mysql_select_db($base) or die('La base de données n\'existe pas');
$query="delete from message where id='$id'";
mysql_query($query);
mysql_close();
header('location:Admin.php');
}
?>