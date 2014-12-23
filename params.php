<?php
try
					{
						$bdd = new PDO('mysql:host=localhost;dbname=orderfast', 'root', '');
					}
					catch(Exception $e)
					{
							die($e->getMessage());

					}
?>
