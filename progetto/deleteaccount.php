<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/delete.css">
</head>
<body>
<?php
	$token=$_GET["token"];
	$id=$_GET["id"];
	if(!empty($_POST["submit"])){
		$conn=mysqli_connect("localhost","root","","stage");
		$email=$_POST["email"];
		$password=$_POST["passwords"];
		$sql="SELECT * FROM utenti WHERE token='$token'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) { // CONTROLLA CHE ABBIA RESTITUITO QUALCOSA
			$row = mysqli_fetch_assoc($result);
			if($row["Password"]== md5($password) && $row["Email"]== $email){
				$sql= "DELETE FROM opere WHERE IDutente = $id";
				mysqli_query($conn, $sql);
				$sql= "DELETE FROM voti WHERE IDutente = $id";
				mysqli_query($conn, $sql);
				$sql= "DELETE FROM utenti WHERE token='$token'";
				if(mysqli_query($conn, $sql)){
					sleep(3);
					header("Location: http://localhost/stage/progetto/index.php");
				}
				else{
					echo "Qualcosa è andato storto";
				}	
			}
			else{
				echo "I dati non corrispondono";
			}
			
		}
		else{
			echo "Qualcosa è sbagliato";
		}

	}
	$sql="SELECT sessione FROM UTENTI WHERE IDutente = $_GET[tok]";
	$result= mysqli_query($conn,$sql);
	$row= mysqli_fetch_assoc($result);
	if($_GET["tok"]!=$_SESSION["ID"] || $row["sessione"] != $_SESSION["sessione"]){
		header("Location:http://localhost/stage/progetto/index.php");
	}
?>
	<form method="post">
		<input type="text" name="email" placeholder="Email">
		<input type="password" name="passwords" placeholder="Password">	
		<input type="submit" name="submit" value="Elimina account">	
	</form>
</body>
</html>