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
			<form action="connect.php" method="post">
				<table class="menuform">
						<tr>
							<td>
								
							</td>
						</tr>
				</table>
			</form>
			<br/>
			<table class="menutab">
				<tr>
					<td>
						<div class="interneMenuGauche">
							<a href="#">Comptes adhérents</a>
						</div>
					</td>
					<td class="caseLogo">
						<div class="interneLogo">
							<a href="Accueil.php"><img src="images/BDElogo.jpg" width="150px" class="logo" />	</a>
						</div>
					</td>
					<td>
						<div class="interneMenuDroite">
							<a href="disconnect.php" align="right">Se déconnecter</a>
						</div>
					</td>
				</tr>
			</table>
			<div class="contenu">
			
				<h1>Publier un statut</h1>
				
				<div id="bloc_gestion">
								<form action="choixTypeStatut.php" method="post">
									<table>
										<tr>
											<td>Titre :</td>
											<td><input type="text" name="titre" size="15" /></td>
										</tr>
										<tr>
											<td>Choix du type de statut : </td>
											<td>
												Cafet <input type="radio" name="type" value="cafet" checked />
												Event <input type="radio" name="type" value="event" />
												Cours <input type="radio" name="type" value="cours" /> 
											</td>
										</tr>
										<tr>
											<td>Texte :</td>
											<td><input type="text" name="texte" size="50" /></td>
										</tr>
										<tr>
											<td>date de debut de publication :</td>
											<td>
												<?php 
												$anNow=date("Y"); 
												?>
												<select name="anneedebut" size="1">
												<?php
													for($année=$anNow;$année<=($anNow+2);$année++){
														echo "<option value=\"$année\">$année</option>";
													}
												?>
												</select>
												<select name="moisdebut" size="1">
													<option>Janvier</option>
													<option>Février</option>
													<option>Mars</option>
													<option>Avril</option>
													<option>Mai</option>
													<option>Juin</option>
													<option>Juillet</option>
													<option>Août</option>
													<option>Septembre</option>
													<option>Octobre</option>
													<option>Novembre</option>
													<option>Décembre</option>
												</select>
												<select name="jourdebut" size="1">
												<?php
													for($jour=1;$jour<=31;$jour++){
														echo "<option value=\"$jour\">$jour</option>";
													}
												?>
													
											</td> 
										</tr>
										<tr>
											<td>Heure de début de publication :</td>
											<td>
												<select name="heuredebut" size="1">
													<?php
														for($heure=0;$heure<=23;$heure++){
															echo "<option value=\"$heure\">$heure</option>";
														}
													?>	
												</select>
												:
												<select name="minutedebut" size="1">
													<?php
														for($minute=0;$minute<=59;$minute++){
															if ($minute<=9){
																echo "<option value=\"0$minute\">0$minute</option>";
															}
															else{
																echo "<option value=\"$minute\">$minute</option>";
															}
														}
													?>	
												</select>
											</td>
										</tr>
										<tr>
											<td>date de fin de publication :</td>
											<td>
												<?php 
												$anNow=date("Y"); 
												?>
												<select name="anneefin" size="1">
												<?php
													for($année=$anNow;$année<=($anNow+2);$année++){
														echo "<option value=\"$année\">$année</option>";
													}
												?>
												</select>
												<select name="moisfin" size="1">
													<option>Janvier</option>
													<option>Février</option>
													<option>Mars</option>
													<option>Avril</option>
													<option>Mai</option>
													<option>Juin</option>
													<option>Juillet</option>
													<option>Août</option>
													<option>Septembre</option>
													<option>Octobre</option>
													<option>Novembre</option>
													<option>Décembre</option>
												</select>
												<select name="jourfin" size="1">
												<?php
													for($jour=1;$jour<=31;$jour++){
														echo "<option value=\"$jour\">$jour</option>";
													}
												?>
													
											</td> 
										</tr>
										<tr>
											<td>Heure de fin de publication :</td>
											<td>
												<select name="heurefin" size="1">
													<?php
														for($heure=0;$heure<=23;$heure++){
															echo "<option value=\"$heure\">$heure</option>";
														}
													?>	
												</select>
												:
												<select name="minutefin" size="1">
													<?php
														for($minute=0;$minute<=59;$minute++){
															if ($minute<=9){
																echo "<option value=\"0$minute\">0$minute</option>";
															}
															else{
																echo "<option value=\"$minute\">$minute</option>";
															}
														}
													?>	
												</select>
											</td>
										</tr>
										<tr>
											<td><input type="submit" value="Publier" /></td>
										</tr>
									</table>
								</form>
<!-- Gestion des statuts ------------------------------------------------------------------ -->
								<br/>
								<h1> Statuts en cours : </h1>
								<table  class ="admintable"> 
									<tr>
										<th>Titre</th> 
										<th>Type</th> 
										<th>Texte</th> 
										<th>Date debut</th>
										<th>Heure debut</th>
										<th>Date fin</th>
										<th>Heure fin</th>
									</tr>
									
									<?php
										require 'params2.php';
										mysql_connect($host,$user,$password) or die('Erreur le connexion au SGBD.');
										mysql_select_db($base) or die('La base de données n\'existe pas');
										$query='SELECT * FROM statut';
										$r=mysql_query($query);
										mysql_close();
										
										while($a=mysql_fetch_object($r)){
										$titre = $a->TITRE; 
										$type = $a->TYPE;
										$texte = $a->TEXTE;
										$datedebut = $a->DATEDEBUT;
										$heuredebut = $a->HEUREDEBUT;
										$datefin = $a->DATEFIN;
										$heurefin = $a->HEUREFIN;
										
										echo"<tr>
												<td>$titre</td>
												<td>$type</td>
												<td>$texte</td>
												<td>$datedebut</td>
												<td>$heuredebut</td>
												<td>$datefin</td>
												<td>$heurefin</td>
											</tr>";
										}
									?>
								</table>
								<br/>
<!-- Gestion des messages ------------------------------------------------------------------ -->
								<h1>Messages reçus :</h1> 
								<table class="admintable"> 
									<tr>
										<th>Nom</th> 
										<th>Prenom</th> 
										<th>Mail</th> 
										<th>Groupe ou département</th>
										<th>Message</th>
										<th>Date</th>
										<th>Heure</th>
									</tr>
									
									<?php
										require 'params2.php';
										mysql_connect($host,$user,$password) or die('Erreur le connexion au SGBD.');
										mysql_select_db($base) or die('La base de données n\'existe pas');
										$query='SELECT * FROM message';
										$r=mysql_query($query);
										mysql_close();
										
										while($a=mysql_fetch_object($r)){
										$id = $a->ID;
										$nom  = $a->NOM; 
										$prenom  = $a->PRENOM;
										$mail = $a->MAIL;
										$groupe = $a->GROUPE;
										$message = $a->MESSAGE;
										$date = $a-> DATEENVOI;
										$heure = $a-> HEUREENVOI; 
										
										
										echo"<tr>
												<td>$nom</td>
												<td>$prenom</td>
												<td>$mail</td>
												<td>$groupe</td>
												<td>$message</td>
												<td>$date</td>
												<td>$heure</td>
												<td><a href=\"supprMessage.php?id=$id\">SUPPRIMER</a></td>
											</tr>";
										}
									?>
									
								</table>
								
								
									
			
				</div>
			</div>
		</div>
	</body>
	
	
	
	
</html>