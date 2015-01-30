<?php
$serveur =  'localhost';//iutdoua-webetu.univ-lyon1.fr
$user = 'root'; //p1301357
$pass = '';//188364
$bdd = 'ptut';//p1301357
//$port = '3306';

try {
    $cnx = new PDO('mysql:host='.$serveur.';dbname='.$bdd, $user, $pass);
    }
catch(PDOException $e)
{
    echo $e->getMessage();
}

?>