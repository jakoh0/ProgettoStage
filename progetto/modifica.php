<?php 
	session_start();
?>
<!DOCTYPE html>
</html>
<head>
	<link rel="stylesheet" href="css/modifica.css">
	<link rel="shortcut icon" href="img/f2.ico" type="image/x-icon">
	<link rel="icon" href="img/f2.ico" type="image/ico">
</head>
<body>
	<div>
		<?php 
			$conn=mysqli_connect("localhost","root","","stage");
			$nome_img = $_GET["ID"];
			echo "<img src='uploads/$nome_img'>";
			$utente = $_GET["utente"];
			$operaid = $_GET["IDimg"];
			$titolo = $_GET["titolo"];
			
			if(isset($_POST["nuovotitolo"])){
				if(!empty($_POST["titol"])){
					$titol =$_POST["titol"]; 
					$sql = "UPDATE opere SET titolo = '$titol' WHERE opereID = $operaid";
					if(!mysqli_query($conn,$sql)){
						echo "Error updating record: " . mysqli_error($conn);
					}
				}
			}	
			if(!empty($_POST["torna"])){
				header("Location: http://localhost/stage/progetto/mostra.php?ID=$utente&prof=$_SESSION[prof]");
			}	
			if(!empty($_POST["elimina"])){
				
				$sql = "SELECT * FROM opere WHERE opereID = $operaid";
				$result = mysqli_query($conn,$sql);
				$row= mysqli_fetch_assoc($result);
				if($row["Nomeopera"]!= ""){
					unlink("uploads/$row[Nomeopera]");
				}
				
				$sql = "DELETE FROM opere WHERE opereID = $operaid";
				mysqli_query($conn, $sql);		
				
				$sql = "DELETE FROM voti WHERE opereID = $operaid";
				mysqli_query($conn, $sql);
				
				$sql = "DELETE FROM svoti WHERE opereID = $operaid";
				mysqli_query($conn, $sql);
				
				$sql = "DELETE FROM commenti WHERE opereID = $operaid";
				mysqli_query($conn, $sql);
				sleep(1);
				header("Location: http://localhost/stage/progetto/mostra.php?ID=$utente&prof=$_SESSION[prof] ");
	
			}	


			$sql="SELECT sessione FROM utenti WHERE IDutente = $_GET[utente]";
			$result= mysqli_query($conn,$sql);
			$row= mysqli_fetch_assoc($result);
			if($_GET["utente"]!=$_SESSION["ID"] || $row["sessione"] != $_SESSION["sessione"]){
				header("Location:http://localhost/stage/progetto/index.php");
			}
			
		?>
		<div id="titolo">
			<div><h3>Titolo dell'opera: </h3><p><?php echo $titolo?></p></div>
			<div><h3>Caricato da: </h3><p> <?php  $sql = "SELECT * FROM utenti WHERE IDutente = $utente";
										$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
										echo $row["Nome"]." ". $row["Cognome"];?></p>
										</div>	
		</div>
		<form method="post" id="f">
			<div>
			<input type="text" name="titol" placeholder="Inserisci il nuovo titolo">
			<input type="submit" name="nuovotitolo" value="Invia">
			</div>
			<input name="elimina" type="submit" value="Elimina immagine">
			<input name="torna" type="submit" value="Torna alla mostra">
		</form>
	</div>
	<div id="testocommento">
		<?php 
			$sql ="SELECT commenti.datain,commenti.IDutente,commenti.testo,commenti.opereID,utenti.Nome,utenti.Cognome 
					FROM utenti RIGHT JOIN commenti ON commenti.IDutente = utenti.IDutente 
					WHERE commenti.opereID = $operaid";
			$result = mysqli_query($conn, $sql);
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					echo "<br><a href= 'http://localhost/stage/progetto/profutente.php?ID=$nome_img&IDimg=$_GET[IDimg]&utente=$utente&di=$row[IDutente]' >Commento di ".$row["Nome"]." ".$row["Cognome"]."</a>";
					echo "<form method='post'><label >$row[testo]</label><button type=submit name=eliminare value=$row[IDutente]>Elimina commento</button></form>";
					echo "_____________________________________________________________";
				}
			}
			if(isset($_POST["eliminare"])){
				
				$app=$_POST["eliminare"];
				$sql = "DELETE FROM commenti WHERE IDutente = $app";
				mysqli_query($conn, $sql);
				header("Refresh:0.5");
			}		
		?>
	</div>
</body>
</html>