<?php
require_once 'cnx.php';
?>
<?php
if (!empty($_POST) && strlen($_POST['login'])>4 && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $login = addslashes($_POST['login']);
    $email = addslashes($_POST['email']);              
    $password = md5($_POST['password']);  
    $token = md5(uniqid(rand()));  //sha1
    
    $q = array('login'=>$login, 'email'=>$email, 'password'=>$password, 'token'=>$token);
    $sql = 'INSERT INTO membres (login, email, password, token) VALUES (:login, :email, :password, :token)';
    $req = $cnx->prepare($sql);
    $req->execute($q);
     header('Location:private.php');
    
   /* $to = $email;
    $sujet = 'Activation de votrre compte';
    $body = '
    Bonjour, veuillez activer votre compte en cliquant ici -> <a href="http://localhost/siteperso/activate.php?token='.$token.'&email='.$to.'">Activation du compte</a>';
   
    $entete = "MINE-Version: 1.0\r\n";
    $entete .= "Content-type: text/html; charset=UTF-8\r\n";
    $entete .= 'FROM: marine.alcade@gmail.com' . "\r\n" . 'Reply-To: marine.alcade@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
    
    mail($to,$sujet,$body,$entete);  */  //Marche que en serveur non local
    
} 
else {
    if (!empty($_POST) && strlen($_POST['login'])<4){
        $error_login = 'Votre login doit comporter au minumum 4 caractères !';
    }
    if (!empty($_POST) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $error_email = 'Votre Mail n\'est pas valide !';         
    
    } 
}


?>

<!doctype html> 
<html>
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=9; IE=10; IE=11"/>
		
	</head>

	
	<body>
	


	<h2>S'enregistrer</h2>
	
</br>
</br>
    
S'enregistrer &agrave; l'espace membre :<br />
    
<Form action="register.php" method="POST">

    
Votre login : <INPUT TYPE="text" NAME="login" placeholder="Entrez votre login" required="required"/> </br>

<div> <?php if(isset($error_login)) { echo $error_login;} ?></div>
    
Votre adresse mail : <INPUT TYPE="text" NAME="email" placeholder="Entrez votre mail" required="required"/> </br>

<div> <?php if(isset($error_email)) { echo $error_email;} ?></div>

Mot de passe : <input type="password" name="password" placeholder="Entrez votre mot de passe" required="required"/> </br>

<input type="submit" value="s'inscrire" name="s'inscrire"/></br>
</Form>

</br>
</br>
<p style="text-align:right"> Retour &agrave; la page de membre pour se connecter: <a style="color: #56739A" href="index.php"> ICI </a> </p> 
</body>
</html>