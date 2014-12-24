<?php
session_start();
?>

<!doctype HTML>

	<head>
		<title>Acceuil</title>
		<link rel="stylesheet" href="style.css">
		<meta charset="utf-8">
		
	</head>
	
	<body>
		<div class="menu">
			<?php
				include("menu.php");
			?>
			
			<div class="contenu">
				<form action="message.php" method="post">
					<h1> Envoie nous un petit message</h1> 
					<table>
						<tr>
							<td>Nom:</td>
							<td><input name="nom" type="text" /></td>
						</tr>
						<tr>
							<td>Prénom:</td>
							<td><input name="prenom" type="text" /></td>
						</tr>
						<tr>
							<td>Adresse mail:</td>
							<td><input name="mail" type="text" /></td>
						</tr>
						<tr>
							<td>Groupe ou département si tu n'es pas en info:</td>
							<td><input name="groupe" type="text" /></td>
						</tr>
						
						<tr>
							<td>Message:</td>
							<td><input name="message" type="text" rows="10" /></td>
						</tr>
						<tr>
							<td><input type="submit" value="Envoyer"/></td>
						</tr>
					</table>
					
				</form>
			</div>
		</div>
	</body>
	
	
	
	
</html>