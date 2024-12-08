<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="img/f2.ico" type="image/x-icon">
	<link rel="icon" href="img/f2.ico" type="image/ico">
	<link rel="stylesheet" href="css/notifiche.css">
	<?php include "funzioni/stampa.php"?>
	<title>Notifiche</title>
</head>
<body>
	
	<?php
		$id= $_GET["id"];
		notifiche($id);
		$conn=mysqli_connect("localhost","root","","stage");
		if(isset($_POST["approva"])){
			$sql ="UPDATE approvazione SET  verifica = 1 WHERE IDutente = $_POST[approva] ";
			mysqli_query($conn, $sql);
		}
		elseif(isset($_POST["rifiuta"])){
			$sql ="UPDATE approvazione SET  verifica = -1 WHERE IDutente = $_POST[rifiuta] ";
			mysqli_query($conn, $sql);
		}
		if(isset($_POST["torna"])){
			header("Location: http://localhost/stage/progetto/benvenuto.php?tok=$_GET[id]&prof=$_GET[prof]");
		}
		if(isset($_POST["visita"])){
			header("Location: http://localhost/stage/progetto/ridiutati.php?id=$_GET[id]&prof=$_GET[prof]");
		}
		if(isset($_POST["app"])){
			header("Location: http://localhost/stage/progetto/approvazioni.php?id=$_GET[id]&prof=$_GET[prof]");
		}
		
		$sql="SELECT sessione FROM utenti WHERE IDutente = $_GET[id]";
		$result= mysqli_query($conn,$sql);
		$row= mysqli_fetch_assoc($result);
		if($_GET["id"]!=$_SESSION["ID"] || $row["sessione"] != $_SESSION["sessione"]){
			header("Location:http://localhost/stage/progetto/index.php");
		}
	
	?>
	<form method="post">
		<div>
			<button type="submit" name = "visita">Utenti rifiutati</button>
			<button type="submit" name = "app">Utenti approvati</button>
		</div>
		<button type="submit" name = "torna">Torna indietro</button>

	</form>
</body>
</html>