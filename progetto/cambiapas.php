<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="img/registrazione.ico" type="image/x-icon">
	<link rel="icon" href="img/registrazione.ico" type="image/ico">
	<link rel="stylesheet" href="css/pas.css">
	<?php include "funzioni/token.php"?>
</head>
<body>
	<?php
		$prectoken=$_GET["tok"];
		$epassword="";
		$ok=0;
		if(!empty($_POST["invio"])){
			
			$conn=mysqli_connect("localhost","root","","stage");

			$password=$_POST["password"];
			$confpassword=$_POST["confpassword"];
			
			if($password!=$confpassword){					// CONTROLLA CRITERI PASSWORD
				$epassword="Le password non coincidono";

			}
			elseif($password=="" || $confpassword==""){
				$epassword="------Inserire una password------";

				
			}
			elseif(!(preg_match("/[A-Z]/",$password) &&preg_match("/[a-z]/",$password) &&preg_match("/[0-9]/",$password) &&preg_match("/[\W_]/",$password) && strlen($password)>=10)){
				$epassword="------Errato ex: Esempio#00------";

			}
			else{
				$password=md5($password);
				$sql="SELECT Password,token
					  FROM utenti
					  WHERE token=$prectoken";
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) { // CONTROLLA CHE ABBIA RESTITUITO QUALCOSA
				  
					while($row = mysqli_fetch_assoc($result)) {	// CONTROLLI CHE PASSWORD NON SIA LA PRECEDENTE
						if($row["Password"]==$password){
							$ok=1;
							break;
						}
					}
				}
	  
				if($ok==0){// AGGIORNA PASSWORD
					$sql="UPDATE utenti 
					  SET Password='$password' WHERE token='$prectoken'";
					if(mysqli_query($conn, $sql)){
						echo "Password cambiata con successo";
						echo "<form id='torna home' action='index.php'><button>Torna alla pagina iniziale</button>";
					}
					$token_n = aggiorna($prectoken);// AGGIORNA TOKEN
					$sql="UPDATE utenti 								
						  SET token=$token_n WHERE token=$prectoken";
					mysqli_query($conn, $sql);

					
					
				
				}
				else{
					echo "Non pui immettere la password precedente";
				}
			}
			
		}
	?>
	<div>																																																																																																																																																																																																																																					
		<form method="post">
			<input type="password" name="password" placeholder="Nuova password">
			<input type="password" name="confpassword" placeholder="Conferma nuova password">
			<label><?php echo $epassword; ?></label>
			<input type="submit" name="invio">
		</form>
	</div>
</body>
</html>