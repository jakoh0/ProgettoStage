<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/gara.css">
	<?php include "C:/wamp64/www/stage/progetto/funzioni/veicoli.php" ?>
	<link rel="shortcut icon" href="C:/wamp64/www/stage/progetto/img/f2.ico" type="image/x-icon">
	<link rel="icon" href="C:/wamp64/www/stage/progetto/img/f2.ico" type="image/ico">
</head>
<body>
	<?php
		$tok = $_GET["tok"];
		$macchina = $_GET["veicolo"];
		$nome = $_GET["nome"];
		$veicolo_utente= new Veicolo($macchina,100);
		$veicolo_sito= new Veicolo("Panda",100);
		if(!empty($_POST["restart"])){
			header("Location: http://localhost/stage/progetto/race/gara.php?tok=$tok&veicolo=$macchina&nome=$nome");
		}
		if(!empty($_POST["torna"])){
			header("Location: http://localhost/stage/progetto/benvenuto.php?tok=$tok&veicolo=$macchina&nome=$nome");
		}
	?>
	
	<div id="centro">
		<div>
			<h2><?php echo strtoupper($_GET["nome"])?></h2>
			<?php
				while($veicolo_utente -> stato_carburante() >0){
					$veicolo_utente -> run();
					if($veicolo_utente -> stato_carburante() <0){
						break;
					}
					$veicolo_utente -> stampa();
				}
			?>
		</div>
		<div>
			<h2><?php echo strtoupper("Veicolo 2")?></h2>
			<?php
				while($veicolo_sito -> stato_carburante() >0){
					$veicolo_sito -> run();
					if($veicolo_sito -> stato_carburante() <0){
						break;
					}
					$veicolo_sito -> stampa();
				}
			?>
		</div>
	</div>

	<div id="risultato">
		<h1>
			<?php
				if($veicolo_utente -> stato_carburante() <=0 && $veicolo_sito -> stato_carburante() <=0 ){
					if($veicolo_utente -> vincitore()>$veicolo_sito -> vincitore()){
						echo "<br>Hai vinto";
						echo "<br><form method ='post'><button type=submit name=restart>Ricomincia Gara</button></form>";
						echo "<form method ='post'><input type=submit  name=torna value='Torna alla schermata di benvenuto'></input></form>";
					}
					elseif($veicolo_utente -> vincitore()==$veicolo_sito -> vincitore()){
						echo "Pareggio";
						echo "<br><form method ='post'><button type=submit name=restart>Ricomincia Gara</button></form>";
						echo "<form method ='post'><input type=submit  name=torna value='Torna alla schermata di benvenuto'></input></form>";
					}
					else{
						echo "Hai perso";
						echo "<br><form method ='post'><button name=restart>Ricomincia Gara</button></form>";
						echo "<form method ='post'><input type=submit  name=torna value='Torna alla schermata di benvenuto'></input></form>";
					}
				}
			?>
		</h1>
		
	</div>
</body>
</html>