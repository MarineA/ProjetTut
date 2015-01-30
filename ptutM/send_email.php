
<?php
/* Si le formulaire est envoyé alors on fait les traitements */
if (isset($_POST['envoye']))
{
    /* Récupération des valeurs des champs du formulaire */
    if (get_magic_quotes_gpc())
    {
      $civilite		= stripslashes(trim($_POST['civilite']));
      $nom	     	= stripslashes(trim($_POST['nom']));
      $expediteur	= stripslashes(trim($_POST['email']));
      $sujet		= stripslashes(trim($_POST['sujet']));
      $message		= stripslashes(trim($_POST['message']));
    }
    else
    {
      $civilite		= trim($_POST['civilite']);
      $nom		    = trim($_POST['nom']);
      $expediteur	= trim($_POST['email']);
      $sujet		= trim($_POST['sujet']);
      $message		= trim($_POST['message']);
    }
 
    /* Expression régulière permettant de vérifier si le 
    * format d'une adresse e-mail est correct */
    $regex_mail = '/^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$/i';
 
    /* Expression régulière permettant de vérifier qu'aucun 
    * en-tête n'est inséré dans nos champs */
    $regex_head = '/[\n\r]/';
 
    /* Si le formulaire n'est pas posté de notre site on renvoie 
    * vers la page d'accueil */
    if($_SERVER['HTTP_REFERER'] != 'https://iutdoua-webetu.univ-lyon1.fr/~p1301357/sitephp/send_email.php')
    {
      header('Location:https://iutdoua-webetu.univ-lyon1.fr/~p1301357/sitephp/private.php/');
    }
    /* On vérifie que tous les champs sont remplis */
    elseif (empty($civilite) 
           || empty($nom) 
           || empty($expediteur) 
           || empty($sujet) 
           || empty($message))
    {
      $alert = 'Tous les champs doivent être renseignés';
    }
    /* On vérifie que le format de l'e-mail est correct */
    elseif (!preg_match($regex_mail, $expediteur))
    {
      $alert = 'L\'adresse '.$expediteur.' n\'est pas valide';
    }
    /* On vérifie qu'il n'y a aucun header dans les champs */
    elseif (preg_match($regex_head, $expediteur) 
            || preg_match($regex_head, $nom) 
            || preg_match($regex_head, $sujet))
    {
        $alert = 'En-têtes interdites dans les champs du formulaire';
    }
    /* Si aucun problème et aucun cookie créé, on construit le message et on envoie l'e-mail */
    elseif (!isset($_COOKIE['sent']))
    {
        /* Destinataire (votre adresse e-mail) */
        $to = 'marine.alcade@gmail.com';
 
        /* Construction du message */
        $msg  = 'Bonjour,'."\r\n\r\n";
        $msg .= 'Ce mail a été envoyé depuisle site de Marine ALCADE par '.$civilite.' '.$nom."\r\n\r\n";
        $msg .= 'Voici le message qui vous est adressé :'."\r\n";
        $msg .= '***************************'."\r\n";
        $msg .= $message."\r\n";
        $msg .= '***************************'."\r\n";
 
        /* En-têtes de l'e-mail */
        $headers = 'From: '.$nom.' <'.$expediteur.'>'."\r\n\r\n";
 
        /* Envoi de l'e-mail */
        if (mail($to, $sujet, $msg, $headers))
        {
            $alert = 'E-mail envoy&eacute avec succ&eagraves ! Merci je repondrais au plus vite';
 
            /* On créé un cookie de courte durée (ici 120 secondes) pour éviter de 
            * renvoyer un mail en rafraichissant la page */
            setcookie("sent", "1", time() + 120);
 
            /* On détruit la variable $_POST */
            unset($_POST);
        }
        else
        {
            $alert = 'Erreur d\'envoi de l\'e-mail';
        }
 
    }
    /* Cas où le cookie est créé et que la page est rafraichie, on détruit la variable $_POST */
    else
    {
        unset($_POST);
    }
}
?>
<!doctype html> 
<html>
	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="style.css">
        <link rel="icon"  href="images/logo_BDE.ico" />
		<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=9; IE=10; IE=11"/>
		
	</head>

	
	<body>
 
<?php
if (!empty($alert))
{
    echo '<p style="color:red">'.$alert.'</p>';
}
?>
  <div class="menu">
		<?php
			include("menu.php");
		?>
		
			<div class="contenu">
                
<form action="send_email.php" method="post">
    <p>
        <table>
            <tr>
                <td>
        <label for="civilite">Civilit&eacute; :</label>
                    </td>
                <td>
        <select id="civilite" name="civilite">
            <option 
                value="mr"
                <?php 
                    if (!isset($_POST['civilite']) || $_POST['civilite'] == 'mr')
                    {
                        echo ' selected="selected"';
                    }
                ?>
            >
                Monsieur
            </option>
            <option 
                value="mme"
                <?php 
                    if (isset($_POST['civilite']) && $_POST['civilite'] == 'mme')
                    {
                        echo ' selected="selected"';
                    }
                ?>
            >
                Madame
            </option>
            <option 
                value="mlle"
                <?php 
                    if (isset($_POST['civilite']) && $_POST['civilite'] == 'mlle')
                    {
                        echo ' selected="selected"';
                    }
                ?>
            >
                Mademoiselle
            </option>
            </td>
                </tr>
            
        </select>
    </p>
    <p>
        <tr>
        <td>
        <label for="nom">Entrez votre Nom/Pr&eacute;nom :</label>
            </td>
        <td>
        <input type="text" id="nom" name="nom" 
        	value="<?php echo (isset($_POST['nom'])) ? $nom : '' ?>" 
        />
            </td>
      </tr>
    </p>
        
    <p>
        <tr>
        <td>
        <label for="email">Entrez votre e-mail :</label>
            </td>
            <td>
        <input type="text" id="email" name="email" 
        	value="<?php echo (isset($_POST['email'])) ? $expediteur : '' ?>"
        />
        </td>
      </tr>
    </p>
    <p>
        <tr>
        <td>
        <label for="sujet">Entrez le sujet :</label>
        </td>
            <td>
        <input type="text" id="sujet" name="sujet" 
        	value="<?php echo (isset($_POST['sujet'])) ? $sujet : '' ?>"
        />
         </td>
      </tr>
    </p>
    <p>
        <tr>
        <td>
        <label for="message">Entrez votre message :</label>
            </td>
            <td>
        <textarea id="message" name="message" cols="40" rows="4">
			<?php echo (isset($_POST['message'])) ? $message : '' ?>
        </textarea>
        </td>
      </tr>
    </p>
    <p>
        </table>
        <input type="submit" name="envoye" value="Envoyer" />
    </p>
</form>
 
        <p> Revenir &agrave; la page principale :<a style="color: #56739A"  href="private.php">Page Membre</a></p>
</br>
</br>
      
        </div>
        </html>div>
        
</body>
</html>