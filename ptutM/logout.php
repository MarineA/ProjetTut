<?php
session_start();
$_SESSION = array();
session_destroy();
header('Localisation:index.php');
?>

<!doctype html> 
<html>
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=9; IE=10; IE=11"/>
        <link rel="stylesheet" href="style.css">
        <link rel="icon"  href="images/logo_BDE.ico" />
		
	</head>

	
	<body>
        <div class="menu">
		<?php
			include("menu.php");
		?>
	
<div class="contenu">

	<h1>Deconnexion</h1>
	
        Merci de votre visite et à bientôt  ! 
</br>
</br>
   Se reconnecter :  </br>
    <a href="index.php"> Se connecter</a>

   </div>
</div>
</body>
</html>