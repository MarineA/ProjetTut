<?php
require_once  'cnx.php';
?>

<?php
$token = $_GET['token'];
$email = $_GET['email']; 
if(!empty($_GET)){
    $q = array('email'=>$email,'token'=>$token);
    $sql = 'SELECT email, token FROM membres WHERE email = :email AND token = :token';
    $req = $cnx->prepare($sql);
    $req->execute($q);
    $count = $req->rowCount($sql);
    
    if ($count == 1) {
        $v = array('email'=>$email,'activer'=>'1');
        // Vérifier si l'utilisateur est actif
        $sql = 'SELECT email, activer FROM membres WHERE email = :email AND activer = :activer';
        $req = $cnx->prepare($sql);
        $req->execute($v);
        $dejactif = $req->rowCount($sql);
        
        if($dejactif == 1){
            $erroor_actif = 'Utilisateur déja activé !';
        } else{
            //Sinon on active l'utilisateur
            $u = array('email'=>$email,'activer'=>'1');
            $sql = 'UPDATE membres SET activer = :activer WHERE email = :email';
        $req = $cnx->prepare($sql);
        $req->execute($u);
        $activated = 'Votre compte est désormais actif';
                }
                
                } else {
        //Utilisateur =inconnu
        $prob_token = 'Mauvais Token';
                }
                }
                

?>
<!doctype html> 
<html>
	<head>
		<meta charset="utf-8"/>
		<title> Marine ALCADE </title>
		<link rel="shortcut icon" type="image/x-icon" href="faviconm.ico" />
		<link rel="stylesheet" type="text/css" href="design.css">
		<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=9; IE=10; IE=11"/>
		
	</head>

	
	<body>
	

<?php include("menu.php"); ?>
	
	

	<div id ="contenu">
	<h2>Contact</h2>
	
</br>
</br>
    
Connexion &agrave; l'espace membre :<br />

   <?php 
if(isset($error_actif)){echo $error_actif;}
    ?>
    
    <?php 
if(isset($activated)){echo $activated;}
    ?>
    
    <?php 
if(isset($prob_token)){echo $prob_token;}
    ?>

     </div>
<?php include("pieddepage.php"); ?>
   
</body>
</html>

