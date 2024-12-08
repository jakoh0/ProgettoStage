<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="img/f2.ico" type="image/x-icon">
	<link rel="icon" href="img/f2.ico" type="image/ico">
	<link rel="stylesheet" href="css/nome.css">
	<title>Benvenuto</title>
</head>
<body>
	<?php
		
		$conn=mysqli_connect("localhost","root","","stage");
		$id = $_GET["tok"];
		$imgg=$_GET["prof"];
		$sql="SELECT token,IDutente,profilo FROM utenti WHERE IDutente=$id";
		$result = mysqli_query($conn, $sql);
		if(!empty($_POST["delete"])){
			if (mysqli_num_rows($result) > 0) { // CONTROLLA CHE ABBIA RESTITUITO QUALCOSA
				$row = mysqli_fetch_assoc($result);
				sleep(1);
				header("Location: http://localhost/stage/progetto/deleteaccount.php?token=$row[token]&id=$row[IDutente]");
			}
			
		}		
		if(!empty($_POST["gioco"])){
			sleep(1);
			header("Location: http://localhost/stage/progetto/race/imposta.php?ID=$row[token]"); 
		}		
		if(!empty($_POST["mostra"])){
			sleep(1);
			header("Location: http://localhost/stage/progetto/mostra.php?ID=$id&prof=$imgg");
		}
		$nomefile;
		if( !empty($_POST["submit"])){

			$target_dir = "profili/";	//directory di dove viene salvata

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
						echo "Non è stato caricato un file";
					}
				}
				else{
					if(move_uploaded_file($_FILES["filecaricato"]["tmp_name"],$target_file)){	// è il file che tiene temporaneamente il file uplodato
						echo "<br>Il file ". $_FILES["filecaricato"]["name"]. " è stato caricato";
						$conn=mysqli_connect("localhost","root","","stage");
						$sql="UPDATE utenti
							  SET profilo = '$nomefile' WHERE IDutente = $id";
						mysqli_query($conn,$sql);
						header("Location: http://localhost/stage/progetto/benvenuto.php?tok=$id&prof=$nomefile");
					}
					else{
						echo "<br>Nessun file caricato";
					}
					
				}
			}
		}
		if(isset($_POST["notiche"])){
			header("Location: http://localhost/stage/progetto/notifiche.php?id=$id&prof=$_GET[prof]");
		}
		$sql="SELECT sessione FROM UTENTI WHERE IDutente = $_GET[tok]";
		$result= mysqli_query($conn,$sql);
		$row= mysqli_fetch_assoc($result);
		if($_GET["tok"]!=$_SESSION["ID"] || $row["sessione"] != $_SESSION["sessione"]){
			header("Location:http://localhost/stage/progetto/index.php");
		}
		
		
	?>
	<div>
		<form action="index.php">
			<button>Logout</button>
		</form>
		
		<?php 
			if($_GET["tok"]!=11111110){
				echo "	<form method='post'>
						<input type ='submit' name='delete' value='Elimina account'>
						</form>";
			}?>
		
	</div>
	<h1>BENVENUTO <?php echo strtoupper($_SESSION["nomeutente"]);?></h1>
	<div id="profilo">
		<?php echo "<button id='immagine'><a href='http://localhost/stage/progetto/info.php?id=$_GET[tok]'><img src= 'profili/$imgg'width='256px' height='256px'></a></button>"?>
		<?php 
			if($_GET["tok"]!=11111110){
				echo "		<form method='post' enctype='multipart/form-data' id='immagineprof'>
					<input type='file' name='filecaricato'  value='Inserisci immagine'>
					<input type='submit' name='submit'>
					</form>";
			}?>

	</div>
	
	<form method="post">
		<input type="submit" name ="mostra" value="Entra nella mostra">
	</form>
	<?php 
		$prova="";
			if($_GET["tok"]!=11111110){
				$conn=mysqli_connect("localhost","root","","stage");
				$sql="SELECT * FROM approvazione WHERE utenteID=$id AND verifica = 0";
				$result = mysqli_query($conn, $sql);				
				if(mysqli_num_rows($result) >0){
					$prova = mysqli_num_rows($result);
					$prova= " ".$prova."⚠";
				}
				
				echo "<form method='post'>
					<button type='submit' name='notiche'>Vedi notifiche</button>".$prova."
					</form>";

			}?>
	
</body>
</html>