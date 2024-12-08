<?php 
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<?php 
		include "funzioni/token.php";
	?>
	<link rel="stylesheet" href="css/home.css">
	<title>Home</title>
	<link rel="shortcut icon" href="img/f2.ico" type="image/x-icon">
	<link rel="icon" href="img/f2.ico" type="image/ico">	
	<script>
		function messagge() { 
			alert("Utente non trovato"); 
		}
		function messagge1() { 
			alert("Riempire correttamente i campi"); 
		}
	</script>
	
</head>
<body>

<!--<input type="password" id="pwd">
<input type="button" onclick="showPwd()" value="Mostra/nascondi password">
<script>
      function showPwd() {
        var input = document.getElementById('pwd');
        if (input.type === "password") {
          input.type = "text";
        } else {
          input.type = "password";
        }
      }
</script>-->

	<?php 
		$_SESSION["a"]=rand(1,10);
		$spassword="Clicca sul seguente link per impostare una nuova password";
		$subject="Password dimenticata";
		$ok=1;
		$error="";
		if(!empty($_POST["invia"])){	
			$email=$_POST["emailutente"];

			$password=$_POST["password"];
			$conn=mysqli_connect("localhost","root","","stage");
			$sql="SELECT * FROM utenti WHERE Email='$email'";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {	  
				while($row = mysqli_fetch_assoc($result)) {
					if($row["Email"]==$email && $row["Password"]==md5($password)){
						$_SESSION["nomeutente"]=$row["Nome"];
						$_SESSION["ID"]=$row["IDutente"];
						$_SESSION["prof"]= $row["profilo"];
						$_SESSION["sessione"]= sessione();
						header("Location: http://localhost/stage/progetto/captcha.php?t=$_SESSION[a]&tok=$row[IDutente]&prof=$row[profilo]") ;
						$ok=0;
						break;
					}
				}	
				$sql="UPDATE utenti SET sessione=$_SESSION[sessione] WHERE IDutente = $_SESSION[ID]";
				mysqli_query($conn,$sql);
			}
			if(empty($email) && empty($password)){
				echo '<script type="text/JavaScript"> messagge1();</script>';
			}
			elseif($ok==1){
				echo '<script type="text/JavaScript"> messagge();</script>';
				$error= "Se non hai un account registrati";
			}
		}
		if(!empty($_GET["wow"])){
			if($_GET["wow"]==3265981470){
				header("Location: https://preview.redd.it/fktuppkre7p51.gif?width=720&format=mp4&s=2206960b8ecd29d61fcabe71d8440dd76db3e30e");
			}
		}
		
		if(!empty($_POST["ospite"])){
			$_SESSION["sessione"]= 0;
			$_SESSION["ID"]=11111110;
			$_SESSION["nomeutente"]="Ospite";
			$_SESSION["prof"]= "default.jpg";
			header("Location: http://localhost/stage/progetto/benvenuto.php?tok=11111110&prof=default.jpg");
		}
	?>

	<div class="campi">
		<form method="post">
			<?php echo $error;?>
			<input type="text" name="emailutente" placeholder="Email"></input>			
			<input type="password" name="password" placeholder="Password"></input>	
			<input class="invio" type="submit" name="invia" value="Invia"></input>			
			<input type="submit" name="ospite" value="Entra come ospite"></input>			
		</form>
		<form action="registrati.php" class="di">
			<input type="submit" name="registrati" value="Registrati"></input>
		</form>
		<form action="email_pas.php" id="marginb" >
			<input class="invio"type="submit" name="cambiapass" value="Cambia password"></input>
		</form>
	</div>
	<div id="sfondomale">
		<img src="img/mclaren.gif">

	</div>
	
	
</body>
</html>