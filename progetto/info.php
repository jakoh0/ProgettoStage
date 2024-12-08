<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="img/f2.ico" type="image/x-icon">
	<link rel="icon" href="img/f2.ico" type="image/ico">
	<link rel="stylesheet" href="css/utente.css">
	<title>Dati account</title>
</head>
<body>
	<?php
		$id = $_GET["id"];

		$sql =" SELECT * FROM utenti WHERE IDutente = $id";
		$conn=mysqli_connect("localhost","root","","stage");
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0){
			while($row= mysqli_fetch_assoc($result)){
				$nome=$row["Nome"];
				$cognome=$row["Cognome"];
				$profilo=$row["profilo"];
				$email=$row["Email"];
				$indirizzo=$row["Indirizzo"];
				$citta=$row["Citta"];
				$numero=$row["Numeroditelefono"];
				$data=$row["Datadinascita"];
			}
		}
		echo "<a href ='http://localhost/stage/progetto/profili/$profilo' id='per'><img src='profili/$profilo'></a>";
		echo "<h2>$nome $cognome</h2>";
		echo "<h3 style='margin-top:3%'>Email: $email</h3>";
		echo "<h3>Indirizzo: $indirizzo</h3>";
		echo "<h3>Città: $citta</h3>";
		echo "<h3>Numero di telefono: $numero</h3>";
		echo "<h3>Data di nascita: $data</h3>";
		
		
		if(isset($_POST["helo"])){
			header("Location: http://localhost/stage/progetto/benvenuto.php?tok=$_GET[id]&prof=$_SESSION[prof]");
		}
	
	
	?>
	
	<div>
		<form method="post">
			<input type="submit" name="helo" value="Indietro">
		</form>
	</div>

	
</body>
</html>