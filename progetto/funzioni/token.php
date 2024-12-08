<?php
	function ricerca(){
		$a=[];
			$token=0;
			for($i=0;$i<5;$i++){
				$a[$i]=rand(1,9);
				$token=$a[$i].$token;
		}
		$conn=mysqli_connect("localhost","root","","stage");
		$sql="SELECT token FROM utenti WHERE token='$token'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) { // CONTROLLA CHE ABBIA RESTITUITO QUALCOSA
		  
			while($row = mysqli_fetch_assoc($result)) {	// DA COME ARRAY OGNI RECORD
				if($row["token"]==$token){
					ricerca();
				}
			}
		}
		else{
			return $token;
		}
	}
	
?>
<?php
	function aggiorna($prectoken){
		$a=[];
		$token_n=0;
		for($i=0;$i<5;$i++){
			$a[$i]=rand(1,9);
			$token_n=$a[$i].$token_n;
		}
		
		$conn=mysqli_connect("localhost","root","","stage");
		$sql="SELECT token FROM utenti WHERE token=$token_n";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) { // CONTROLLA CHE ABBIA RESTITUITO QUALCOSA		
			while($row = mysqli_fetch_assoc($result)) {	// DA COME ARRAY OGNI RECORD
			
				if($row["token"]==$token_n){
					aggiorna($prectoken);
				}
			}
		}
		else{

			return $token_n;
		}
	}

	
?>


<?php
	function id(){
		$a=[];
			$token=0;
			for($i=0;$i<3;$i++){
				$a[$i]=rand(1,9);
				$token=$a[$i].$token;
		}
		$conn=mysqli_connect("localhost","root","","stage");
		$sql="SELECT IDutente FROM utenti WHERE IDutente='$token'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) { // CONTROLLA CHE ABBIA RESTITUITO QUALCOSA
		  
			while($row = mysqli_fetch_assoc($result)) {	// DA COME ARRAY OGNI RECORD
				if($row["IDutente"]==$token){
					ricerca();
				}
			}
		}
		else{
			return $token;
		}
	}
	
?>
<?php
	function sessione(){
		$a=[];
			$sessione=0;
			for($i=0;$i<5;$i++){
				$a[$i]=rand(1,9);
				$sessione=$a[$i].$sessione;
		}
		$conn=mysqli_connect("localhost","root","","stage");
		$sql="SELECT sessione FROM utenti WHERE token='$sessione'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) { // CONTROLLA CHE ABBIA RESTITUITO QUALCOSA
		  
			while($row = mysqli_fetch_assoc($result)) {	// DA COME ARRAY OGNI RECORD
				if($row["sessione"]==$sessione){
					ricerca();
				}
			}
		}
		else{
			return $sessione;
		}
	}
	
?>