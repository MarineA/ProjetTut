<?php
session_start();
require_once 'cnx.php';
?>

<?php
if(!empty($_POST)){
    $email = $_POST['email'];
    $password = md5($_POST['password']);
                    
    $q = array('email'=>$email,'password'=>$password);
    $sql = 'SELECT email, password FROM membres WHERE email = :email AND password = :password';
    $req = $cnx->prepare($sql);
    $req->execute($q);
    $count = $req->rowCount($sql);
    
    if($count == 1) {
        //Vérifier si l'utilisateur est actif
        $sql = 'SELECT email, password FROM membres WHERE email = :email AND password = :password';
    $req = $cnx->prepare($sql);
    $req->execute($q);
    $actif = $req->rowCount($sql);
    if($actif == 1) {
        $_SESSION['Auth'] = array( 'email' => $email, 'password' => $password);
        
        header('Location:private.php');
    }else{
        $error_actif = 'Votre compte n\'est pas actif ! Vérifier vos mails pour activer votre compte';
    }
            
    } else {
        //Si l'utilisateur inconnu
        $error_unknown ='Utilisateur inexistant !';
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
	
	

           
	<h2>Se connecter</h2>

Se connecter &agrave; l'espace membre :<br />
    
<Form action="index.php" method="POST">
   
Votre adresse mail : <INPUT TYPE="text" NAME="email" placeholder="Entrez votre mail" required="required"/> </br>

Mot de passe : <input type="password" name="password" placeholder="Entrez votre mot de passe" required="required"/> </br>

<input type="submit" value="se connecter" name="connexion"/></br>
</Form>

<p> Ou vous enregistrer : 
    <a style="color: #56739A" href="register.php"> S'enregistrer</a></p>


   
</body>
</html>