<?php 
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="img/f2.ico" type="image/x-icon">
	<link rel="icon" href="img/f2.ico" type="image/ico">
	<link rel="stylesheet" href="css/carica.css">
	<?php include "funzioni/token.php"?>
	<title>Carica</title>
</head>
<body>
	
	<?php 
		$conn=mysqli_connect("localhost","root","","stage");
		if( !empty($_POST["submit"])){
			$titolo = $_POST["titolo"];

			$target_dir = "uploads/";	//directory di dove viene salvata

			$nomefile= $_FILES["filecaricato"]["name"];
			$target_file = $target_dir . basename($_FILES["filecaricato"]["name"]); //path del file che viene uplodato, _FILES serve per prendere il nome del file
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); //estensione del file
				
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" || $imageFileType == "" ){
				if(!($imageFileType == "" || $imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif")){
					echo "<br>Inserire un'immagine";
				}	
			}
			else{
				
				if(file_exists($target_file)){ //richiede il path

					if($nomefile!=" "){
						echo "<br>Il file è già presente";
						echo " non è stato caricato un file";
					}
				}
				else{
					if(move_uploaded_file($_FILES["filecaricato"]["tmp_name"],$target_file)){	// è il file che tiene temporaneamente il file uplodato
						echo "<br>Il file ". $_FILES["filecaricato"]["name"]. " è stato caricato";
						
						$idutente = $_GET["ID"];
						$id_opera = ricerca();
						$sql="INSERT INTO opere(opereID,Nomeopera, IDutente,titolo)
							  VALUES ('$id_opera','$nomefile','$idutente','$titolo')";
						mysqli_query($conn,$sql);
					}
					else{
						echo "<br>Nessun file caricato";
						echo " non è stato caricato un file";
					}
					
				}
			}
		}
		if(!empty($_POST["mostra"])){
			sleep(1);
			header("Location: http://localhost/stage/progetto/mostra.php?ID=$_GET[ID]&prof=$_GET[prof]");
		}
		$sql="SELECT sessione FROM utenti WHERE IDutente = $_GET[ID]";
		$result= mysqli_query($conn,$sql);
		$row= mysqli_fetch_assoc($result);
		if($_GET["ID"]!=$_SESSION["ID"] || $row["sessione"] != $_SESSION["sessione"]){
			header("Location:http://localhost/stage/progetto/index.php");
		}
	?>
	<form method="post"  enctype="multipart/form-data">
		<h3>CARICA UN FILE</h3>
		<input type="file" name="filecaricato">
		<input type="text" name="titolo" placeholder="Inserisci un titolo per l'opera" required>
		<input type="submit" name="submit">
	</form>
	<form method="post">
		<input type="submit" name="mostra" value="Torna alla mostra">
	</form>	
</body>
</html>