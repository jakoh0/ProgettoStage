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
	<title>Approvati</title>
</head>
<body>
	
	<?php
		$id= $_GET["id"];
		approvati($id);
		$conn=mysqli_connect("localhost","root","","stage");
		if(isset($_POST["rifiuta"])){
			$sql ="UPDATE approvazione SET  verifica = -1 WHERE IDutente = $_POST[rifiuta] ";
			mysqli_query($conn, $sql);
		}
		if(isset($_POST["torna"])){
			header("Location: http://localhost/stage/progetto/notifiche.php?id=$_GET[id]&prof=$_GET[prof]");
		}
	
	?>
	<form method="post">
		<button type="submit" name = "torna">Torna indietro</button>
	</form>
</body>
</html>