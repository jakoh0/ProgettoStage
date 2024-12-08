<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="img/f2.ico" type="image/x-icon">
	<link rel="icon" href="img/f2.ico" type="image/ico">
	<link rel="stylesheet" href="css/mostra.css">
	<?php include "funzioni/stampa.php"?>
	<title>Mostra</title>
	<script>
		function cambia($color){
			document.body.style.background = $color; 
			document.riquadro.style.color = $scritte; 
		}
	</script>
</head>
<body>
	<?php 
		date_default_timezone_set("Europe/Rome");
		if(!empty($_POST["mostra"])){
			sleep(1);
			header("Location: http://localhost/stage/progetto/carica.php?ID=$_GET[ID]&prof=$_GET[prof]");
		}
		if(!empty($_POST["indietro"])){
			sleep(1);
			header("Location: http://localhost/stage/progetto/benvenuto.php?tok=$_GET[ID]&prof=$_GET[prof]");
		}
		if(!empty($_GET["wow"])){
			if($_GET["wow"]=="andrea"){
				echo "<img class='andrea' src='https://me.stecca.dev/img/avatar.png'>";
			}
			elseif($_GET["wow"]=="campig8"){
				echo "<img class='andrea' src='img/c.png'>";
			}
		}
		// target = "_blank"
		if($_GET["ID"]!=$_SESSION["ID"]){
			header("Location:http://localhost/stage/progetto/index.php");
		}
	?>
	<div id="blocca">
		<form method="post">
			<?php 
				if($_GET["ID"] != 11111110){
					echo "<input type='submit' name='mostra' value='Carica immagine nella galleria'>
							<button type='submit' name='caricate'>Mostra quello che hai caricato te</button>";
				}
			?>
			
			<div id= "ordina">				
				<select name="languages"onchange="this.form.submit()">
					<option>Ordina per</option>
					<option value="nvoti">Numero di voti</option>
					<option value="sommavoti">Somma dei voti</option>
					<option value="">Normale</option>
				</select>
			</div>		
		</form>
		<h2>BENVENUTO NELLA MOSTRA</h2>
	</div>
	<div id="riquadri">
		<?php 
			if(isset($_POST["languages"])){
				if(isset($_POST["caricate"])){
					stampa_tuo($_GET["ID"]);
					echo "<form method =post id=ordine><button type=submit name=caricate>Torna alla mostra</button></form>";
				}	
				elseif($_POST["languages"] == ""){
					stampa($_GET["ID"]);
				}
				else{
					mostraimmagini($_GET["ID"],$_POST["languages"]);
				}
			}
			else{
				stampa($_GET["ID"]);
			}
			/*$ora1 =  date('H:i');
			echo $ora1;
			$ora2 =  "12:05";			
			$differenza = $ora2-$ora1;*/ // PER ORA LINK FAI MENO E VEDI DOPO QUANTO HA APERTO IL LINK 
			// SE DIFF > N RIMANDARE  IL LINK E CMABIARE NUMERO DI "SICUREZZA" PASSATOGLI CON IL LINK
		?>
	</div>
	<div id="relativo">
		<form method="post">
			<input type="submit" name="indietro" value="Torna indietro">
		</form>
			<button class="bottone" onclick="cambia('#1d2a35')">Tema scuro</button>
			<button class="bottone" onclick="cambia('#E4E3D6')">Tema chiaro</button>
	</div>

</body>
</html>