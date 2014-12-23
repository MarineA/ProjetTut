<!doctype HTML>

	<head>
		<title>Accueil</title>
		<link rel="stylesheet" href="css_ppp.css">
		<meta charset="utf-8" />
	</head>
	
	<body>
	
<!-- Affichage des choix de repas -->
		
		<form action="commande.php" method="POST">
		
			<?php

			?>
			<div id="repas">
				<?php
					echo "Menu +1€<br/>";
					include("params.php");
					$reponse = $bdd->query("SELECT * FROM repas");
					while ($donnees = $reponse->fetch()){
						if($donnees['reste'] != 0 OR $donnees['nombre'] != 0){
							$nom=$donnees['nom'];
							$prix=$donnees['prix'];
							$prix=$prix+$choix;
							echo"<INPUT TYPE='radio' NAME='repas' value='$nom'>";
							echo $nom." ".$prix."€ <br>";
						}
					}
				?>
			</div>
			
			
<!-- Affichage des choix des ingredients -->
		
				<div id="ingredients">
					<?php
						include("params.php");
						$reponse = $bdd->query("SELECT * FROM ingredients");
						while ($donnees = $reponse->fetch()){
							if($donnees['reste'] != 0){
								$nom=$donnees['nom'];
								$sup=$donnees['supplement'];
								echo"<input type='checkbox' name='ingredients[]' value=$nom >";
								echo $nom;
								if($sup !=0){
									echo " (supplement : ".$sup."€)";
								}
								echo "</br>";
							}
						}
					?>
				</div>
		
<!-- Affichage des choix de sauces -->
		
				<div id="sauces">
					<?php
						include("params.php");
						$reponse = $bdd->query("SELECT * FROM sauces");
						while ($donnees = $reponse->fetch()){
							if($donnees['reste'] != 0){
								$nom=$donnees['nom'];
								echo"<INPUT TYPE='checkbox' NAME='sauces[]' value='$nom'>";
								echo $nom."<br>";
							}
						}
					?>
				</div>
				
			
<!-- Affichage des choix de boisson -->

					<div id="boissons">
					<?php
						include("params.php");
						$reponse = $bdd->query("SELECT * FROM boissons");
						while ($donnees = $reponse->fetch()){
							if($donnees['reste'] != 0 OR $donnees['nombre'] != 0){
								$nom=$donnees['nom'];
								echo"<INPUT TYPE='radio' NAME='boissons' value='$nom'>";
								echo $nom."<br>";
							}
						}
					?>
					</div>
			
<!-- Affichage des choix de dessert -->
			
					<div id="desserts">
					<?php
						include("params.php");
						$reponse = $bdd->query("SELECT * FROM desserts");
						while ($donnees = $reponse->fetch()){
							if($donnees['reste'] != 0 OR $donnees['nombre'] != 0){
								$nom=$donnees['nom'];
								echo"<INPUT TYPE='radio' NAME='desserts' value='$nom'>";
								echo $nom."<br>";
							}
						}
					?>
				</div>
				<INPUT TYPE="submit" NAME="valider" value='Suivant'>

			
<!-- valider la commande -->

			<div id="valider">
				
				<?php
					
					if(isset($_POST['valider'])){
						include("params.php");
						
//choix repas
						$n_repas=$_POST['repas'];
						$reponse=$bdd->query("SELECT * FROM repas WHERE nom='$n_repas'");
						while ($donnees = $reponse->fetch()){
							$repas=$donnees['id'];
							$p_repas=$donnees['prix'];
						}
					
//choix ingredients

						$ingredients='0';
						$n_ingredients='0';
						foreach($_POST['ingredients'] as $val){
							$reponse=$bdd->query("SELECT * FROM ingredients WHERE nom='$val'");
							while ($donnees = $reponse->fetch())
							{
								if ($ingredients=='0'){
									$ingredients=$donnees['id'];
									$n_ingredients=$val;
									$sup_ingredients=$donnees['supplement'];
								}
								else{
									$ingredients=$ingredients.','.$donnees['id'];
									$n_ingredients=$n_ingredients.','.$val;
									$sup_ingredients=$p_ingredients + $donnees['supplement'];
								}
							}
						}
					
//Choix sauces
						
					$sauces='0';
					$n_sauces='0';
					foreach($_POST['sauces'] as $val){
						$reponse=$bdd->query("SELECT * FROM sauces WHERE nom='$val'");
						while ($donnees = $reponse->fetch())
						{
							if ($sauces=='0'){
								$sauces=$donnees['id'];
								$n_sauces=$val;
								$sup_sauces=$donnees['supplement'];
							}
							else{
								$sauces=$sauces.','.$donnees['id'];
								$n_sauces=$n_sauces.','.$val;
								$sup_sauces=$sup_sauces + $donnees['supplement'];
							}
						}
					}

//choix boissons
					
					$boissons='0';
					$n_boissons=$_POST['boissons'];
					$reponse=$bdd->query("SELECT * FROM boissons WHERE nom='$n_boissons'");
					while ($donnees = $reponse->fetch()){
						$boissons=$donnees['id'];
						$sup_boissons=$donnees['supplement'];
					}
					
//choix desserts
					$desserts='0';
					$n_desserts=$_POST['desserts'];
					$reponse=$bdd->query("SELECT * FROM desserts WHERE nom='$n_desserts'");
					while ($donnees = $reponse->fetch()){
						$desserts=$donnees['id'];
						$sup_desserts=$donnees['supplement'];
					}
					
//Definition menu
					$choix=0;
					$t_choix=null;
					if($boissons!=0 && $desserts!=0){
						$p_choix=1;
						$t_choix="menu";
					}
					else {
						if($boissons!=0){
							$p_choix=0.5;
						}
						else if($desserts!=0){
							$p_choix=0.8;
						}
						
					}
					
// Definition du prix
					$prix=$p_repas+$sup_ingredients+$sup_sauces+$sup_boissons+$sup_desserts+$p_choix;
					
// Afficher le résumé de la commande 
					
					echo '<b>Recapitulatif :</b></br>'.$n_repas.'</br>';
					if($n_ingredients!='0'){
						echo $n_ingredients.'</br>';
					}
					if($n_sauces!='0'){
						echo $n_sauces.'</br>';
					}
					if($repas=='0'){
						echo "erreur";
					}
					else{
						echo $n_boissons.'</br>'.$n_desserts.'</br>'.'prix: '.$prix.'€</br>';
					
					
					
				?>
				<INPUT TYPE="submit" NAME="confirmer" value='Valider la commande'>
				<?php
					}
					}
				?>
				
				<INPUT TYPE="hidden" name="c_repas" value="<?php echo $repas ?>">
				<INPUT TYPE="hidden" name="c_ingredients" value="<?php echo $ingredients ?>">
				<INPUT TYPE="hidden" name="c_sauces" value="<?php echo $sauces ?>">
				<INPUT TYPE="hidden" name="c_boissons" value="<?php echo $boissons ?>">
				<INPUT TYPE="hidden" name="c_desserts" value="<?php echo $desserts ?>">
				<?php
					if (isset($_POST['confirmer'])){
						include("params.php");
						$repas=$_POST['c_repas'];
						$ingredients=$_POST['c_ingredients'];
						$ingredients=$_POST['c_ingredients'];
						$sauces=$_POST['c_sauces'];
						$boissons=$_POST['c_boissons'];
						$desserts=$_POST['c_desserts'];
						
												
//Teste si la table est vide (si oui creer une fausse commande pour eviter le probleme de la 1ere commande						
					
						$reponse=$bdd->query("SELECT COUNT(*) as nb FROM commandes");
						while ($donnees = $reponse->fetch()){
							$nb=$donnees['nb'];
							if($nb==0){
								$bdd->exec("INSERT INTO commandesdetails VALUES ('0','0','0','0','0','0','0','0')");
								$bdd->exec("INSERT INTO commandes VALUES ('0','0','0','0','0','0','0','0','1','1','1','1','0')");
							}
						}
						
						
//Recherche des ID pour la commande
							$reponse=$bdd->query("SELECT * FROM commandes WHERE id= (SELECT MAX(id) FROM commandes)");
							while ($donnees = $reponse->fetch()){
								$idCommande=$donnees['id']+1;
								$numero=$donnees['numero']+1;
							}
							$reponse=$bdd->query("SELECT * FROM commandesdetails WHERE id= (SELECT MAX(id) FROM commandes)");
							while ($donnees = $reponse->fetch()){
								$id=$donnees['id'];
							}

							
//Recherche d'un serveur avec le moins de commande(active)
							$reponse=$bdd->query("SELECT id FROM comptes WHERE serving=1");
							while ($donnees = $reponse->fetch()){
								$idServ=$donnees['id'];
								$cherche = $bdd->query("SELECT COUNT(idServeur) AS nombre FROM commandes WHERE idServeur='$idServ' AND effectue=0");
								while ($donnees2 = $cherche->fetch()){
									$nombre=$donnees2['nombre'];
									if ($sav_n != null){
										if($sav_n>$nombre){
											$sav_n=$nombre;
											$Serveur=$idServ;
										}
									}
									else{
										$sav_n=$nombre;
										$Serveur=$idServ;
									}
								}
							}
								
//Insertion dans la base de donnée
							if($repas!=0){
								$bdd->exec("INSERT INTO commandesdetails VALUES ('$id',' $idCommande','$repas','$ingredients','$sauces','$boissons','$desserts','0')");
								$bdd->exec("INSERT INTO commandes VALUES ('$idCommande','$numero','0','0','0','$Serveur','0','0','1','0','0','0','0')");
							}
							else{
								echo "erreur";
							}
								
					}
						
				?>
				
			</div>
			</form>
	</body>
</html>