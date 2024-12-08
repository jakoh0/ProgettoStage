<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="C:\wamp64\www\stage\progetto\css\imp.css">
	<?php include "C:/wamp64/www/stage/progetto/funzioni/token.php"?>
</head>
<body>
	<?php 
		$conn=mysqli_connect("localhost","root","","stage");
		$gara=$nome=$macchina=$tok=$enome="";
		$tok=$_GET["token"];
		$vnome="Inserisci un nome";
			
		if(!empty($_POST["invio"])){
			
			$lettere= "/^[a-zA-Z' ]*$/";
			
			$nome=$_POST["giocatore"];

			$nome=trim($nome);
			if(!preg_match($lettere,$nome)){
				$enome ="Errore nel nome";
			}
			elseif($nome==""){
				$enome ="Errore nel nome";
			}else{
				$vnome=$nome;
			}
			$macchina=$_POST["nome_m"];
			
			$a=[];
			for($i=0;$i<6;$i++){
				$a[$i]=rand(1,9);
				$gara=$a[$i].$gara;
			}
			if(!ricerca($gara)){
				$a=[];
				$gara=0;
				for($i=0;$i<6;$i++){
					$a[$i]=rand(1,9);
					$gara=$a[$i].$gara;
				}
			}
			if(preg_match($lettere,$nome) && $nome!=""){	
				$sql="INSERT INTO gare(IDgara,Nomegiocatore,Macchina,tokengiocatore)
					  VALUES ($gara, '$nome', '$macchina','$tok')";
				if(mysqli_query($conn, $sql)){
					header("Location: http://localhost/stage/progetto/race/gara.php?tok=$tok&veicolo=$macchina&nome=$nome");
				}
				else{
					echo "Qualcosa è andato storto ";
				}
			}
		}
	?>
	<form method="post">
		<input name="giocatore" type="text" placeholder="<?php echo $vnome ?>">
		<label><?php echo $enome ?></label>
		
		<label> Scegli la macchina </label>
		<select name="nome_m" >
			<option value ="Audi">Audi</option>
			<option value ="Volvo">Volvo</option>
			<option value ="Panda">Panda</option>
			<option value ="Trattore">Trattore</option>
		</select><br>
		<input name="invio" type="submit" placeholder="Invia"><br>
	</form>

</body>
</html>