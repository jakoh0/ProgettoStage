<?php 
	session_start();
?>
<!DOCTYPE html>
</html>
<head>
	<link rel="stylesheet" href="css/utente.css">
	<link rel="shortcut icon" href="img/f2.ico" type="image/x-icon">
	<link rel="icon" href="img/f2.ico" type="image/ico">
</head>
<body>

	<?php
		$id = $_GET["di"];

		$sql =" SELECT * FROM utenti WHERE IDutente = $id";
		$conn=mysqli_connect("localhost","root","","stage");
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0){
			while($row= mysqli_fetch_assoc($result)){
				$nome=$row["Nome"];
				$cognome=$row["Cognome"];
				$profilo=$row["profilo"];
			}
		}
		echo "<a href ='http://localhost/stage/progetto/profili/$profilo'id='per'><img src='profili/$profilo'></a>";
		echo "<h2>$nome $cognome</h2>";
		
		
	?>
	<div id="blocca">
		<?php
			
			$sql = "SELECT Nomeopera,IDutente,opereID,titolo
					FROM opere
					WHERE IDutente= $id";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) { // CONTROLLA CHE ABBIA RESTITUITO QUALCOSA
				while($row = mysqli_fetch_assoc($result)) {	// DA COME ARRAY OGNI RECORD
				
				$iD = $row["IDutente"];
				$id_img = $row["opereID"];
				$titolo = $row["titolo"];
				$sql1 = "SELECT Nome,Cognome FROM utenti WHERE IDutente= $iD";

				$riga = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
				$nome = $row["Nomeopera"];		// NOME DELL'IMMAGINE			
				$fname = $riga["Nome"];					
				$lname = $riga["Cognome"];					
					
					echo "
						  <div class='riquadro'><button><a href='http://localhost/stage/progetto/vota.php?ID=$nome&IDimg=$id_img&utente=$_GET[utente]&titolo=$titolo&di=$id'>
							<img src='uploads/$nome'>
							<p><b>$fname $lname</b></p>
							</input></button></a>
						  </div>";
				}//<p>$voti voti</p>
			}
			$sql="SELECT sessione FROM utenti WHERE IDutente = $_GET[utente]";
			$result= mysqli_query($conn,$sql);
			$row= mysqli_fetch_assoc($result);
			if($_GET["utente"]!=$_SESSION["ID"] || $row["sessione"] != $_SESSION["sessione"]){
				header("Location:http://localhost/stage/progetto/index.php");
			}
		?>
	</div>


</body>
</html>