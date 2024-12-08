
<?php 
	function stampa($ID){
		$conn=mysqli_connect("localhost","root","","stage");
		$sql = "SELECT Nomeopera,IDutente,opereID,titolo
				FROM opere
				WHERE IDutente!= $ID";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) { // CONTROLLA CHE ABBIA RESTITUITO QUALCOSA
				while($row = mysqli_fetch_assoc($result)) {	// DA COME ARRAY OGNI RECORD
				
				$id = $row["IDutente"];
				$id_img = $row["opereID"];
				$titolo = $row["titolo"];
				$Idutente = $row["IDutente"];
				$sql1 = "SELECT Nome,Cognome FROM utenti WHERE IDutente= $id";

				$riga = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
				$nome = $row["Nomeopera"];		// NOME DELL'IMMAGINE			
				$fname = $riga["Nome"];					
				$lname = $riga["Cognome"];					
					
					echo "
						  <div class='riquadro'><button><a href='http://localhost/stage/progetto/vota.php?ID=$nome&IDimg=$id_img&utente=$ID&titolo=$titolo&di=$Idutente'>
							<img src='uploads/$nome'>
							<p><b>$fname $lname</b></p>
							</input></button></a>
						  </div>";
				}//<p>$voti voti</p>
			}
	}
	
	function mostraimmagini($ID,$ord){
		$conn=mysqli_connect("localhost","root","","stage");
	
		$sql = "SELECT svoti.nvoti,svoti.sommavoti,opere.opereID,opere.IDutente,opere.Nomeopera,opere.titolo FROM svoti LEFT JOIN opere ON opere.opereID =svoti.opereID WHERE opere.IDutente !=$ID ORDER BY `svoti`.$ord DESC";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) { // CONTROLLA CHE ABBIA RESTITUITO QUALCOSA
			while($row = mysqli_fetch_assoc($result)) {	// DA COME ARRAY OGNI RECORD
			
				$id = $row["IDutente"];
				$id_img = $row["opereID"];
				$nvoti = $row[$ord];
				$titolo = $row["titolo"];
				$Idutente = $row["IDutente"];
				$sql1 = "SELECT Nome,Cognome FROM utenti WHERE IDutente= $id";

				$riga = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
				$nome = $row["Nomeopera"];		// NOME DELL'IMMAGINE			
				$fname = $riga["Nome"];					
				$lname = $riga["Cognome"];					
					
					echo "
						  <div class='riquadro'><button><a href='http://localhost/stage/progetto/vota.php?ID=$nome&IDimg=$id_img&utente=$ID&voti=$nvoti&titolo=$titolo&di=$Idutente'>
							<img src='uploads/$nome'>
							<p><b>$fname $lname</b></p>
							<p>$nvoti voti</p>
							</input></button></a>
						  </div>";
			}//<p>$voti voti</p>
		}
		
	}
	
	function stampa_tuo($ID){
		$conn=mysqli_connect("localhost","root","","stage");
		$sql = "SELECT Nomeopera,IDutente,opereID,titolo
				FROM opere
				WHERE IDutente= $ID";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) { // CONTROLLA CHE ABBIA RESTITUITO QUALCOSA
				while($row = mysqli_fetch_assoc($result)) {	// DA COME ARRAY OGNI RECORD
				
				$id = $row["IDutente"];
				$id_img = $row["opereID"];
				$titolo = $row["titolo"];
				$Idutente = $row["IDutente"];
				$sql1 = "SELECT Nome,Cognome FROM utenti WHERE IDutente= $id";

				$riga = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
				$nome = $row["Nomeopera"];		// NOME DELL'IMMAGINE			
				$fname = $riga["Nome"];					
				$lname = $riga["Cognome"];					
					
					echo "
						  <div class='riquadro'><button><a href='http://localhost/stage/progetto/modifica.php?ID=$nome&IDimg=$id_img&utente=$ID&titolo=$titolo&di=$Idutente'>
							<img src='uploads/$nome'>
							<p><b>$fname $lname</b></p>
							</input></button></a>
						  </div>";
				}//<p>$voti voti</p>
			}
	}
	
	function notifiche($id){
		$conn=mysqli_connect("localhost","root","","stage");
		//$sql = "SELECT utenti.Nome,utenti.Cognome, approvazione.verifica FROM utenti LEFT JOIN approvazione ON approvazione.IDutente = $id WHERE utenti.IDutente = $id";
		$sql = "SELECT utenti.Nome,utenti.Cognome, approvazione.verifica,approvazione.IDutente FROM utenti LEFT JOIN approvazione ON approvazione.IDutente = utenti.IDutente WHERE approvazione.utenteID = $id";
		$result= mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0){
			echo "<h3>RICHIESTE IN SOSPESO</h3>";
			while($row = mysqli_fetch_assoc($result)){
				if($row["verifica"]==0){
					echo "<form method='post' id=not><label>Richiesta di $row[Nome] $row[Cognome]</label><div><button type='submit' name='approva' value = $row[IDutente]>Approva utente</button><button type='submit' name='rifiuta' value = $row[IDutente]>Rifiuta utente</button></div></form>";
				}
			}
		}
		else{
			echo "<h3>Non hai richieste</h3>";
		}
	}
	
	function rifiutati($id){
		$conn=mysqli_connect("localhost","root","","stage");
		//$sql = "SELECT utenti.Nome,utenti.Cognome, approvazione.verifica FROM utenti LEFT JOIN approvazione ON approvazione.IDutente = $id WHERE utenti.IDutente = $id";
		$sql = "SELECT utenti.Nome,utenti.Cognome, approvazione.verifica,approvazione.IDutente FROM utenti LEFT JOIN approvazione ON approvazione.IDutente = utenti.IDutente WHERE approvazione.utenteID = $id";
		$result= mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0){
			echo "<h3>RICHIESTE RIFIUTATE</h3>";
			while($row = mysqli_fetch_assoc($result)){
				if($row["verifica"]==-1){
					echo "<form method='post' id=not><label>Richiesta di $row[Nome] $row[Cognome]</label><div><button type='submit' name='approva' value = $row[IDutente]>Approva utente</button></div></form>";
				}
			}
		}
		else{
			echo "<h3>Non hai richieste</h3>";
		}
	}
	function approvati($id){
		$conn=mysqli_connect("localhost","root","","stage");
		//$sql = "SELECT utenti.Nome,utenti.Cognome, approvazione.verifica FROM utenti LEFT JOIN approvazione ON approvazione.IDutente = $id WHERE utenti.IDutente = $id";
		$sql = "SELECT utenti.Nome,utenti.Cognome, approvazione.verifica,approvazione.IDutente FROM utenti LEFT JOIN approvazione ON approvazione.IDutente = utenti.IDutente WHERE approvazione.utenteID = $id";
		$result= mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0){
			echo "<h3>RICHIESTE APPROVATE</h3>";
			while($row = mysqli_fetch_assoc($result)){
				if($row["verifica"]==1){
					echo "<form method='post' id=not><label>Richiesta di $row[Nome] $row[Cognome]</label><div><button type='submit' name='rifiuta' value = $row[IDutente]>Rifiuta utente</button></div></form>";
				}
			}
		}
		else{
			echo "<h3>Non hai richieste</h3>";
		}
	}
?>