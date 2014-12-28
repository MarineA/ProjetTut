<!doctype HTML>

	<head>
		<title>Cafet'</title>
		<link rel="stylesheet" href="style.css">
		<link rel="icon"  href="images/logo_BDE.ico" />
		<meta charset="utf-8" />
	</head>
	
	<body>
	<div class="menu">
	
		<?php
			include("menu.php");
			include("params.php");
		?>
		<div class="contenu">
		<?php
			if(isset($_POST['precedent'])||(!(isset($_POST['suivant'])||isset($_POST['confirmer'])))){
		?>
		
<!-- Affichage des choix de repas -->
		<form action="Cafet.php" method="POST">
			<div id="affichage">
			<div id="information">
			<br>
			</div>
			<div id="repas">
			<img src="images/repas.gif"></img></br></br>
				<?php
					$reponse = $bdd->query("SELECT * FROM repas");
					while ($donnees = $reponse->fetch()){
						if($donnees['reste'] != 0 OR $donnees['nombre'] != 0){
							$nom=$donnees['nom'];
							$prix=$donnees['prix'];
							$nb_ingr=$donnees['ingredients'];
							$prix=$prix+$choix;
							$accord="";
							if($nb_ingr>1){
								$accord="s";
							}
							echo"<INPUT TYPE='radio' NAME='repas' value='$nom'>";
							echo " ".$nom."</br><sous-titre>(".$prix."€ ,".$nb_ingr." ingredient".$accord.")</br></br></sous-titre>";
						}
					}
				?>
			</div>
			
			
<!-- Affichage des choix des ingredients -->
		
				<div id="ingredients">
				<img src="images/ingredients.gif"></img></br></br>
					<?php
						$reponse = $bdd->query("SELECT * FROM ingredients");
						while ($donnees = $reponse->fetch()){
							if($donnees['reste'] != 0){
								$nom=$donnees['nom'];
								$sup=$donnees['supplement'];
								echo"<input type='checkbox' name='ingredients[]' value='$nom' >";
								echo " ".$nom;
								if($sup !=0){
									echo "<suplement> (supp : ".$sup."€)</suplement>";
								}
								echo "</br>";
							}
						}
					?>
				</div>
		
<!-- Affichage des choix de sauces -->
		
				<div id="sauces">
				<img src="images/sauces.gif"></img></br></br>
					<?php
						$reponse = $bdd->query("SELECT * FROM sauces");
						while ($donnees = $reponse->fetch()){
							if($donnees['reste'] != 0){
								$nom=$donnees['nom'];
								$sup=$donnees['supplement'];
								echo"<input type='checkbox' name='sauces[]' value='$nom' >";
								echo " ".$nom;
								if($sup !=0){
									echo "<sous-titre> (supp : ".$sup."€)</sous-titre>";
								}
								echo "</br>";
							}
						}
					?>
				</div>
				
			
<!-- Affichage des choix de boisson -->

					<div id="boissons">
					<img src="images/boissons.gif"></img></br></br>
					<?php
						$reponse = $bdd->query("SELECT * FROM boissons");
						while ($donnees = $reponse->fetch()){
							if($donnees['reste'] != 0){
								$nom=$donnees['nom'];
								$sup=$donnees['supplement'];
								echo"<input TYPE='radio' name='boissons' value='$nom' >";
								echo " ".$nom;
								if($sup !=0){
									echo "<sous-titre> (supp : ".$sup."€)</sous-titre>";
								}
								echo "</br>";
							}
						}
					?>
					</div>
			
<!-- Affichage des choix de dessert -->
			
					<div id="desserts">
					<img src="images/desserts.gif"></img></br></br>
					<?php
						$reponse = $bdd->query("SELECT * FROM desserts");
						while ($donnees = $reponse->fetch()){
							if($donnees['reste'] != 0){
								$nom=$donnees['nom'];
								$sup=$donnees['supplement'];
								echo"<input TYPE='radio' name='desserts' value='$nom' >";
								echo " ".$nom;
								if($sup !=0){
									echo "<sous-titre> (supp : ".$sup."€)</sous-titre>";
								}
								echo "</br>";
							}
						}
					?>
				</div>
				</div>
				<div class="bouton">
					<INPUT TYPE="submit" NAME="suivant" value="" id="bouton_suivant">
				</div>
			</form>
		<?php
			}
		?>
		
<!-- valider la commande -->

			<div id="valider">
				
				<?php
					
					if(isset($_POST['suivant'])){
						
//choix repas
						$repas='0';
						$n_repas=$_POST['repas'];
						$reponse=$bdd->query("SELECT * FROM repas WHERE nom='$n_repas'");
						while ($donnees = $reponse->fetch()){
							$repas=$donnees['id'];
							$p_repas=$donnees['prix'];
						}
					
//choix ingredients

						$ingredients='0';
						$n_ingredients='0';
						$nb_ingredients=0;
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
							$nb_ingredients=$nb_ingredients+1;
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
//Definition supplement plus d'ingrédients
					$sup_nb_ingredients=0;
					$reponse=$bdd->query("SELECT * FROM repas WHERE nom='$n_repas'");
					while ($donnees = $reponse->fetch()){
						$nb_base=$donnees['ingredients'];
						if($nb_ingredients>$nb_base){
							$sup_nb_ingredients=($nb_ingredients-$nb_base)*0.2;
						}
					}
				
					
// Definition du prix
					$prix=$p_repas+$sup_ingredients+$sup_sauces+$sup_boissons+$sup_desserts+$p_choix+$sup_nb_ingredients;

?>
			
			<div id="recap">
<?php
										
// Afficher le résumé de la commande (si un repas est choisi)
					
					if($repas=='0'){
						echo "Veuiller choisir un repas";
					?>
				</div>
					<form action="Cafet.php" method="POST">
					<div class="bouton">
					<?php
					}
					else{
			
						echo '<b>Recapitulatif :</b></br>'.$n_repas.'</br>';
						if($n_ingredients!='0'){
							echo $n_ingredients.'</br>';
						}
						if($n_sauces!='0'){
							echo $n_sauces.'</br>';
						}
						echo $n_boissons.'</br>'.$n_desserts.'</br>'.'prix: '.$prix.'€</br>';
					
?>
<!-- Creation du bouton confirmer si possible -->
				</div>
				<form action="Cafet.php" method="POST">
				<div class="bouton">
					<INPUT TYPE="submit" NAME="confirmer" value="" id="bouton_confirmer">
				<?php
					}
				?>
				
					<INPUT TYPE="submit" NAME="precedent" value="" id="bouton_precedent">
				</div>
				<INPUT TYPE="hidden" name="c_repas" value="<?php echo $repas ?>">
				<INPUT TYPE="hidden" name="c_ingredients" value="<?php echo $ingredients ?>">
				<INPUT TYPE="hidden" name="c_sauces" value="<?php echo $sauces ?>">
				<INPUT TYPE="hidden" name="c_boissons" value="<?php echo $boissons ?>">
				<INPUT TYPE="hidden" name="c_desserts" value="<?php echo $desserts ?>">
				</form>
				<?php
					
				}
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
								
//Insertion dans la base de donnée (si serveur)
								if($Serveur==0){
									echo"Il n'y a pas de personne pouvant recevoir vos commandes";
								}
								else{
								$bdd->exec("INSERT INTO commandesdetails VALUES ('$id',' $idCommande','$repas','$ingredients','$sauces','$boissons','$desserts','0')");
								$bdd->exec("INSERT INTO commandes VALUES ('$idCommande','$numero','0','0','0','$Serveur','0','0','1','0','0','0','0')");
								}
								
							}
					
						
				?>
				
			</div>
		</div>
	</body>
</html>