<?php 
	session_start();
?>
<!DOCTYPE html>
</html>
<head>
	<link rel="stylesheet" href="css/ema_pa.css">
	<link rel="shortcut icon" href="img/f2.ico" type="image/x-icon">
	<link rel="icon" href="img/f2.ico" type="image/ico">
</head>
<body>
	<?php
		if(!empty($_POST["invio"])){
			$conn=mysqli_connect("localhost","root","","stage");
			$email=$_POST["email"];
			$sql="SELECT Email,token FROM utenti WHERE Email='$email'";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) { // CONTROLLA CHE ABBIA RESTITUITO QUALCOSA	  
				while($row = mysqli_fetch_assoc($result)) {		//ASSOCIA RECORD AD ARRAY
					if($row["Email"]==$email){
						$token=$row["token"];
						echo "<a href=http://localhost/stage/progetto/cambiapas.php?tok=$token><button>Cambia la password</button></a>";	
						break;
					}
				}
			}
			else{
				echo "Email non trovata";
			}
		}
	?>
	<div>
		<form method="post">
			<input type="text" name="email" placeholder="Inserisci l'email">
			<input type="submit" name="invio">
		</form>	
	</div>
	
	
</body>
</html>