<?php 
	session_start();
?>
<!DOCTYPE html>
</html>
<head>
	<link rel="stylesheet" href="css/voti.css">
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
			$iD = $_GET["di"];
			if(!empty($_POST["submit"])){
				$conn=mysqli_connect("localhost","root","","stage");
				if(!empty($_POST["ratings"])){
					$voto = $_POST["ratings"]-1;
					$sql = "SELECT * FROM voti WHERE opereID = $operaid AND IDutente = $utente";
					$svoti = "SELECT * FROM svoti WHERE opereID = $operaid";
					$result = mysqli_query($conn, $sql);
					$result1 = mysqli_query($conn, $svoti);
					$nrecord=mysqli_num_rows($result);
					$nrecord1=mysqli_num_rows($result1);
					if ( $nrecord== 0){
						$row = mysqli_fetch_assoc($result);
						$sql = "INSERT INTO voti(opereID,voto,IDutente) VALUES ($operaid,$voto,$utente) ";
						mysqli_query($conn, $sql);
						if($nrecord1==0){
							$sql="INSERT INTO svoti(opereID,sommavoti,nvoti) VALUES ($operaid,$voto,1)";
							mysqli_query($conn, $sql);	
						}
						else{					
							$sql="UPDATE svoti SET sommavoti= sommavoti+$voto,nvoti=nvoti+1 WHERE opereID = $operaid";
							mysqli_query($conn, $sql);
						}
					}
					else{
						echo "Hai già votato questa foto";
						header("Refresh:2");
					}
				}
			}
			if(!empty($_POST["torna"])){
				header("Location: http://localhost/stage/progetto/mostra.php?ID=$utente&prof=$_SESSION[prof]");
			}	
			if(isset($_POST["inserire"])){
				$sql = "SELECT * FROM commenti WHERE IDutente = $utente && opereID = $operaid";
				$result = mysqli_query($conn, $sql);
				if(mysqli_num_rows($result) > 0){
					echo "Hai già commentato questa foto";
					header("Refresh:1");
				}
				else{
					echo "<form method='post' id='testo'>
						 <input name='commento' type='text' placeholder='Inserisci un commento'>
						 <input name='commenta' type='submit' value='Invia commento'>
					  </form>";
				}
			}
			if(!empty($_POST["commenta"]) && !empty($_POST["commento"])){	
				$sql="SELECT * FROM approvazione WHERE IDutente=$utente AND UtenteID = $iD";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);
				if(mysqli_num_rows($result)>0 ){
					if($row["verifica"]==0){
						echo "Devi aspettare che l'autore confermi la tua richiesta";
						if($_POST["commento"] != " "){
							$testo = $_POST["commento"];
							$data = date("Y-m-d");
							$sql="INSERT INTO commenti(opereID,IDutente,testo,datain)
								  VALUES ($operaid,$utente,'$testo','$data')";
							mysqli_query($conn,$sql);
							header("Refresh:2");
							
						}	
						header("Refresh:3");
						
					}
					elseif($row["verifica"]!=-1){
						if($_POST["commento"] != " "){
							$testo = $_POST["commento"];
							$data = date("Y-m-d");
							$sql="INSERT INTO commenti(opereID,IDutente,testo,datain)
								  VALUES ($operaid,$utente,'$testo','$data')";
							mysqli_query($conn,$sql);
							header("Refresh:0");
						}	
					}
					else{
						echo "La tua richiesta di commentare è stata rifiutata ";
						header("Refresh:2");
					}
				}
				else{
					if(!empty($_POST["commenta"]) && !empty($_POST["commento"])){
						if($_POST["commento"] != " "){
							$testo = $_POST["commento"];
							$data = date("Y-m-d");
							$sql="INSERT INTO commenti(opereID,IDutente,testo,datain)
								  VALUES ($operaid,$utente,'$testo','$data')";
							mysqli_query($conn,$sql);
							$sql="INSERT INTO approvazione(IDutente,utenteID,verifica)
								  VALUES ($utente,$iD,0)";
							if(mysqli_query($conn,$sql)){
								echo "<br>Richiesta inviata con successo";
							}
							else{
								echo "<br>C'è stato un problema nella richiesta";
							}
							header("Refresh:2");
							
						}	
					}
				}
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
			<div><h3>Caricato da: </h3><p> <?php  $sql = "SELECT * FROM utenti WHERE IDutente = $iD";
										$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
										echo "<a href='http://localhost/stage/progetto/profutente.php?ID=$nome_img&IDimg=$_GET[IDimg]&utente=$utente&di=$row[IDutente]'>$row[Nome] $row[Cognome]</a>";?></p></div>
			<div class ='rating'>
				<form method ='post'>
			<?php 
				if($utente != 11111110){
					echo "	<input name='ratings' type='radio' value='2'>Like	
							<input name='ratings' type='radio' value='1'>Dislike
							<div>
								<input name='submit' type='submit' value='Invia voto'>
										
							</div>
							<div id='commenti'>
								<button type='submit' name ='inserire'>Inserisci un commento</button>
							</div>";
				}
			?>
				<input name='torna' type='submit' value='Torna alla mostra'>
				</form>
			</div>
		</div>
	</div>
	<div id="testocommento">
		<?php 
			$sql ="SELECT commenti.datain,commenti.IDutente,commenti.testo,commenti.opereID,utenti.Nome,utenti.Cognome 
					FROM utenti RIGHT JOIN commenti ON commenti.IDutente = utenti.IDutente 
					WHERE commenti.opereID = $operaid";

			// MOSTRA COMMENTI
			$result = mysqli_query($conn, $sql);
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					if($utente == $row["IDutente"]){
						$app = $row["IDutente"];
						$verifica = "SELECT verifica,IDutente FROM approvazione WHERE IDutente = $row[IDutente]";
						$risultato = mysqli_query($conn, $verifica);
						
						if(mysqli_num_rows($risultato)>0 ){
							$riga=mysqli_fetch_assoc($risultato);
							if($riga["verifica"]==0 && $riga["IDutente"]==$utente){
								echo "<br>Commento di ".$row["Nome"]." ".$row["Cognome"]." ".$row["datain"]."</a><br>";
								echo "<form method='post'><input type='text' name='commod' value='$row[testo]'> <input id='modcommento' type='submit' name = 'inviy' value='Modifica commento'><button type=submit name=eliminare>Elimina commento</button> commento in fase di approvazione</form>";
								echo "_____________________________________________________________";
							}
							elseif($riga["verifica"]==1){
								echo "<br>Commento di ".$row["Nome"]." ".$row["Cognome"]." ".$row["datain"]."</a><br>";
								echo "<form method='post'><input type='text' name='commod' value='$row[testo]'> <input id='modcommento' type='submit' name = 'inviy' value='Modifica commento'><button type=submit name=eliminare>Elimina commento</button></form>";
								echo "_____________________________________________________________";
							}
						}
						

					}
					else{
						
						$app = $row["IDutente"];
						$verifica = "SELECT verifica,IDutente FROM approvazione WHERE IDutente = $row[IDutente]";
						$risultato = mysqli_query($conn, $verifica);
						
						if(mysqli_num_rows($risultato)>0 ){
							$riga=mysqli_fetch_assoc($risultato);
							if($riga["verifica"]==1 && $riga["IDutente"]!=$utente){
								
								echo "<br><a href= 'http://localhost/stage/progetto/profutente.php?ID=$nome_img&IDimg=$_GET[IDimg]&utente=$utente&di=$row[IDutente]' >Commento di ".$row["Nome"]." ".$row["Cognome"]."</a>";
								echo $row["testo"]."<br>";
								echo "_____________________________________________________________<br>";
							}
						}
						
						
					}
					
				}
			}
			if(!empty($_POST["inviy"])){
				$sql = "SELECT * FROM commenti WHERE IDutente = $app";
				$RESULT= mysqli_query($conn, $sql);
				$row= mysqli_fetch_assoc($RESULT);
				if(!empty($_POST["commod"]) ){	
					if($_POST["commod"]!= $row["testo"] ){
						$ntesto = $_POST["commod"];
						$data = "modificato il ".date("Y-m-d");
						$sql1 = "UPDATE commenti SET testo='$ntesto', datain = '$data' WHERE opereID = $operaid AND IDutente = $utente";
						mysqli_query($conn,$sql1);
						
						header("Refresh:0");
					}
				}
			}
			if(isset($_POST["eliminare"])){
				$sql = "DELETE FROM commenti WHERE IDutente = $app";
				mysqli_query($conn, $sql);
				header("Refresh:0.5");
			}
		?>
	</div>
</body>
</html>