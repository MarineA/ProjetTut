<?php
session_start();
require('auth.php');
if (Auth::islog()){
}
else{
    header('Localisation:index.php');
}
?>

<!doctype html> 
<html>
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=9; IE=10; IE=11"/>
		
	</head>

	
	<body>
	
	<h2>Bienvenue</h2>
        
        Merci de vous &ecirc;tres inscrit sur le site ! 
        Vous &ecirc;tes maintenant membres
</br>
</br>
        <p> Ici vous pouvez commander :  [mettre le lien pour commander] </p>
        
        <p> Vous pouvez aussi nous envoyer un mail : <a style="color: #56739A"  href="send_email.php">E-mail</a> !
            
</br>
</p>
</br>
</br>
    <div id ="logout">
    Pour vous d&eacute;connecter c'est ici : </br>
<a style="color: #56739A" href="logout.php"> Se d&eacute;connecter</a>
    </div>
  </div>  


   
</body>
</html>