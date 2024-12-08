<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="img/f2.ico" type="image/x-icon">
	<link rel="icon" href="img/f2.ico" type="image/ico">
	<link rel="stylesheet" href="css/cap.css">
</head>
<body>
	<h2>INSERISCI IL CAPTCHA</h2>
	<?php

		$name=$captcha="";		

		//indirizzamento tramite get
		
		switch($_GET["t"]){									// PRENDE LA VVARIABILE NEL URL
			case 1:
					echo "<img src='captcha/9yhx6b.png'>";
					$name="9yhx6b";

					break;
			case 2:
					echo "<img src='captcha/c2jz98.png'>";
					$name="c2jz98";

					break;
			case 3:
					echo "<img src='captcha/captcha246.png'>";
					$name="captcha246";

					break;
			case 4:
					echo "<img src='captcha/d99t26.png'>";
					$name="d99t26";

					break;
			case 5:
					echo "<img src='captcha/dsjcbka.png'>";
					$name="dsjcbka";

					break;
			case 6:
					echo "<img src='captcha/jsf8be.png'>";
					$name="jsf8be";

					break;
			case 7:
					echo "<img src='captcha/mkfxc.png'>";
					$name="mkfxc";

					break;
			case 8:
					echo "<img src='captcha/pe3prq.png'>";
					$name="pe3prq";
					break;
			case 9:
					echo "<img src='captcha/44h4y.png'>";
					$name="44h4y";
					break;
			case 10:
					echo "<img src='captcha/y5g9nf.png'>";
					$name="y5g9nf";
					break;
			default: 
					echo "Errore";
		}
			
		if(!empty($_POST["invio"])){
			if($_POST["captchac"]==$name){
				echo "<a href=http://localhost/stage/progetto/benvenuto.php?tok=$_GET[tok]&prof=$_GET[prof]><button>Entra</button></a>";	
			}
			else{
				$_SESSION["a"]= rand(1,10);
				echo "Sbagliato";
				sleep(1.5);
				header("Location: http://localhost/stage/progetto/captcha.php?t=$_SESSION[a]&tok=$_GET[tok]&prof=$_GET[prof]") ;
			}
		}
	?>
	<form method="post" >
		<input type="text" name="captchac"></input>
		<input type="submit" name="invio"></input>
	</form>

</body>
</html>