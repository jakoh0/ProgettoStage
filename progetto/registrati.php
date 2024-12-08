<?php 
	session_start();
?>

<!DOCTYPE html>
<html>
<head>

	<?php 
		include "funzioni/email/email.php";
		include "funzioni/token.php";
		include "funzioni/controllo.php";
	?>

	<link rel="stylesheet" href="css/register.css">
	<link rel="shortcut icon" href="img/registrazione.ico" type="image/x-icon">
	<link rel="icon" href="img/registrazione.ico" type="image/ico">
	<title>Registrati</title>
	<script>
		function messagge() { 
		
			alert("Registrato correttamente"); 
		}
		function messagge1() { 
			alert("E' già presente un account collegato a questa email"); 
		}
		function messagge2() { 
			alert("C'è stato un problema con la registrazione"); 
		}
	</script>
	
	
<!-- inutile solo per scopi futuri -->
	
	<style>
.alert {
  padding: 20px;
  background-color: #f44336;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>
	
</head>
<body>

	<!-- PHP -->
	<?php 
		
		$vnome=$vcognome=$vemail=$vindirizzo=$vdata=$vnazione=$vprovincia=$vtelefono=$vcitta="";

		$conn=mysqli_connect("localhost","root","","stage");
		$enome=$ecognome=$eemail=$eindirizzo=$enazione=$eprovincia=$enumero=$ecitta=$epassword=$edata="";
		$ok=0;
		$sregistrato="Grazie per esserti registrato";
		$subject="Registrazione";

		$lettere= "/^[a-zA-Z' ]*$/";
		if(!empty($_POST["registrati"])){
			
			$nome=$_POST["nomeutente"];

			$nome=trim($nome);
			if(!preg_match($lettere,$nome)){
				$enome ="Errore nel nome";
			}
			elseif($nome==""){
				$enome ="Errore nel nome";
			}else{
				$vnome=$nome;
			}
			
			$cognome=$_POST["cognomeutente"];
			if(!preg_match($lettere,$cognome)){
				$ecognome ="Errore nel cognome";
			}
			elseif(empty($cognome)){
				$ecognome ="Errore nel cognome";
			}else{
				$vcognome=$cognome;
			}
			
			$email=$_POST["emailutente"];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$eemail="Formato dell'email invalido";
			}
			else{
				$vemail=$email;
			}
			if(!empty($_POST["indirizzoutente"])){
				$vindirizzo=$indirizzo=$_POST["indirizzoutente"];
			}
			
			$nazione=$_POST["nazione"];
			$provincia=$_POST["provincia"];
			
			if($nazione=="" || $provincia==""){
				$enazione ="Errore inserire nazione e provincia";
			}
			
			$numero=$_POST["numeroutente"];

			if(strlen($numero)<10 ){
				$enumero="Numero di telefono errato";
			}
			else{
				$vtelefono=$numero;
			}
			$vcitta=$citta=$_POST["cittautente"];
			$password=$_POST["password"];
			$passwordconf=$_POST["passwordconf"];
			$data=$_POST["datautente"];
			if($password!=$passwordconf){
				$epassword="Le password non coincidono";
			}
			elseif($password=="" || $passwordconf==""){
				$epassword="------Inserire una password------";
			}
			elseif(!(preg_match("/[A-Z]/",$password) &&preg_match("/[a-z]/",$password) &&preg_match("/[0-9]/",$password) &&preg_match("/[\W_]/",$password) && strlen($password)>=10)){
				$epassword="------Errato ex: Esempio#00------";
			}

			$hash = md5($password);
			
			$token = ricerca();
			$id = id();
			 
			$ciao = date("d-m-Y");
			$data1 = date_create($ciao);
			$data2 = date_create($data);
			$interval = date_diff($data1, $data2);
			if(empty($citta)){
				$ecitta="Riempi il campo";
			}
			elseif(!controllo_citta($citta)){
				$ecitta="Inserisci una località corretta";
			}
			if(empty($indirizzo)){
				$ecitta="Riempi il campo";
			}
			if( controllo_citta($citta) && preg_match($lettere,$nome) && preg_match($lettere,$cognome) && $password == $passwordconf && $password!="" && $passwordconf!="" && filter_var($email, FILTER_VALIDATE_EMAIL) && $nazione!="" && $provincia!="" && !empty($_POST["datautente"])){
				$sql="SELECT Email FROM utenti WHERE Email='$email'";
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) { // CONTROLLA CHE ABBIA RESTITUITO QUALCOSA
					while($row = mysqli_fetch_assoc($result)) {	// DA COME ARRAY OGNI RECORD
						if($row["Email"]==$email){
							$ok=1;
							break;
						}
					}
				}
				if($ok==0){
					$sql="INSERT INTO utenti(Nome,Cognome,Email,Indirizzo,Provincia,Citta,Datadinascita,Nazione,Numeroditelefono,Password,token,IDutente)
						VALUES('$nome','$cognome','$email','$indirizzo','$provincia','$citta','$data','$nazione','$numero','$hash','$token','$id')";
					if(mysqli_query($conn,$sql)){
						echo '<script type="text/JavaScript"> messagge();</script>';
						//registrato($email,$subject,$sregistrato);  // INVIO EMAIL A REGISTRAZIONE RIUSCITA
					}
					else{
						echo "Ci sono stati dei problemi nella registrazione";
						//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
					}
				}
				else{
					echo '<script type="text/JavaScript"> messagge1();</script>';
					echo "<form action='index.php' class='home'><button>Accedi dalla schermata home</button></form>";
				}
			}
			else{
				echo '<script type="text/JavaScript"> messagge2();</script>';
			}
		}
		$dta= date("Y-m-d");
		//echo var_dump($dta);
		
	?>

	<!--  CAMPI DI INPUT -->
	<form action="index.php">
		<button>Torna alla home</button>
	</form>

	<div class="campi">
	<!-- FARE POPUP CHE TI DICE CHE TI SEI REGISTRATO 
		<div>
			<input name="invia" type="submit" onclick="messagge()">
		</div>
		-->
		
		<form method="POST">
			<div>
				<input name="nomeutente" type="text" placeholder='Nome' value="<?php echo $vnome?>"></input>		
				<input type="text" name="cognomeutente" placeholder="Cognome" value="<?php echo $vcognome?>"></input>	
			</div>
			<div id="nome">
				<label><?php echo $enome?></label>
				<label><?php echo $ecognome?></label>
			</div>
			<div>
				<input type="text" name="emailutente" placeholder="Email" value="<?php echo $vemail?>" ></input>
				<input type="text" name="indirizzoutente" placeholder="Indirizzo" value="<?php echo $vindirizzo?>"></input>
			</div>
			<div id="email">
				<label><?php echo $eemail?></label>
				<label><?php echo $eindirizzo?></label>
			</div>
			<div id="data">
				<label>Data di nascita: </label>
				<input type="date" min="1900-01-01" max="2024-06-11" name="datautente" placeholder="Data di nascita"></input>	
			</div>
			<div id="edata">
				<label><?php echo $edata ?></label>
			</div>
			<div id="nazione">
				<label>Nazione</label>
				<label>Provincia</label>
			</div>
			<div>
				<select class="seleziona" name="nazione">
					<option selected="" value="">Seleziona</option>
					<option value="Afghanistan">Afghanistan</option>
					<option value="Albania">Albania</option>
					<option value="Algeria">Algeria</option>
					<option value="Andorra">Andorra</option>
					<option value="Angola">Angola</option>
					<option value="Antartico">Antartico</option>
					<option value="Arabia Saudita">Arabia Saudita</option>
					<option value="Argentina">Argentina</option>
					<option value="Armenia">Armenia</option>
					<option value="Australia">Australia</option>
					<option value="Austria">Austria</option>
					<option value="Azerbaijan">Azerbaijan</option>
					<option value="Bahamas">Bahamas</option>
					<option value="Bahrain">Bahrain</option>
					<option value="Bangladesh">Bangladesh</option>
					<option value="Barbados">Barbados</option>
					<option value="Belgio">Belgio</option>
					<option value="Belize">Belize</option>
					<option value="Benin">Benin</option>
					<option value="Bhutan">Bhutan</option>
					<option value="Bielorussia">Bielorussia</option>
					<option value="Bolivia">Bolivia</option>
					<option value="Bosnia herzegovina">Bosnia Erzegovina</option>
					<option value="Botswana">Botswana</option>
					<option value="Brasile">Brasile</option>
					<option value="Brunei">Brunei</option>
					<option value="Bulgaria">Bulgaria</option>
					<option value="Burkina faso">Burkina Faso</option>
					<option value="Burundi">Burundi</option>
					<option value="Cambogia">Cambogia</option>
					<option value="Camerun">Camerun</option>
					<option value="Canada">Canada</option>
					<option value="Capo Verde">Capo Verde</option>
					<option value="Ciad">Ciad</option>
					<option value="Cile">Cile</option>
					<option value="Cina">Cina</option>
					<option value="Cipro">Cipro</option>
					<option value="Colombia">Colombia</option>
					<option value="Comore">Comore</option>
					<option value="Corea del Nord">Corea del Nord</option>
					<option value="Corea del Sud">Corea del Sud</option>
					<option value="Costa d'Avorio">Costa d'Avorio</option>
					<option value="Costa Rica">Costa Rica</option>
					<option value="Croazia"></option>
					<option value="Cuba">Cuba</option>
					<option value="Danimarca">Danimarca</option>
					<option value="Dominica">Dominica</option>
					<option value="Ecuador">Ecuador</option>
					<option value="Egitto">Egitto</option>
					<option value="Emirati Arabi">Emirati Arabi</option>
					<option value="Eritrea">Eritrea</option>
					<option value="Estonia">Estonia</option>
					<option value="Etiopia">Etiopia</option>
					<option value="Figi">Figi</option>
					<option value="Filippine">Filippine</option>
					<option value="Finlandia">Finlandia</option>
					<option value="Franica">Francia</option>
					<option value="Gabon">Gabon</option>
					<option value="Gambia">Gambia</option>
					<option value="Georgia">Georgia</option>
					<option value="Germania">Germania</option>
					<option value="Ghana">Ghana</option>
					<option value="Giamaica">Giamaica</option>
					<option value="Giappone">Giappone</option>
					<option value="Giordania">Giordania</option>
					<option value="Grecia">Grecia</option>
					<option value="Grenada">Grenada</option>
					<option value="Groenlandia">Groenlandia</option>
					<option value="Guatemala">Guatemala</option>
					<option value="Guinea">Guinea</option>
					<option value="Guyana">Guyana</option>
					<option value="Haiti">Haiti</option>
					<option value="Honduras">Honduras</option>
					<option value="India">India</option>
					<option value="Indonesia">Indonesia</option>
					<option value="Iran">Iran</option>
					<option value="Iraq">Iraq</option>
					<option value="Irlanda">Irlanda</option>
					<option value="Islanda">Islanda</option>
					<option value="Isole Marshall">Isole Marshall</option>
					<option value="Isole Salomone">Isole Salomone</option>
					<option value="Israele">Israele</option>
					<option value="Italia">Italia</option>
					<option value="Kazakistan">Kazakistan</option>
					<option value="Kenya">Kenya</option>
					<option value="Kirghizistan">Kirghizistan</option>
					<option value="Kiribati">Kiribati</option>
					<option value="Kuwait">Kuwait</option>
					<option value="Laos">Laos</option>
					<option value="Lesotho">Lesotho</option>
					<option value="Lettonia">Lettonia</option>
					<option value="Libano">Libano</option>
					<option value="Liberia">Liberia</option>
					<option value="Libia">Libia</option>
					<option value="Liechtenstein">Liechtenstein</option>
					<option value="Lituania">Lituania</option>
					<option value="Lussemburgo">Lussemburgo</option>
					<option value="Macedonia">Macedonia</option>
					<option value="Madagascar">Madagascar</option>
					<option value="Malawi">Malawi</option>
					<option value="Maldive">Maldive</option>
					<option value="Malesia">Malesia</option>
					<option value="Mali">Mali</option>
					<option value="Malta">Malta</option>
					<option value="Marocco">Marocco</option>
					<option value="Mauritania">Mauritania</option>
					<option value="Mauritius">Mauritius</option>
					<option value="Mexico">Messico</option>
					<option value="Micronesia">Micronesia</option>
					<option value="Moldavia">Moldavia</option>
					<option value="Mongolia">Mongolia</option>
					<option value="Montenegro">Montenegro</option>
					<option value="Mozambico">Mozambico</option>
					<option value="Myanmar">Myanmar</option>
					<option value="Namibia">Namibia</option>
					<option value="Nauru">Nauru</option>
					<option value="Nepal">Nepal</option>
					<option value="Nicaragua">Nicaragua</option>
					<option value="Niger">Niger</option>
					<option value="Nigeria">Nigeria</option>
					<option value="Norvegia">Norvegia</option>
					<option value="Nuova >elanda">Nuova Zelanda</option>
					<option value="Olanda">Olanda</option>
					<option value="Oman">Oman</option>
					<option value="Paesi Bassi">Paesi Bassi</option>
					<option value="Pakistan">Pakistan</option>
					<option value="Palau">Palau</option>
					<option value="Palestina">Palestina</option>
					<option value="Panama">Panama</option>
					<option value="Nuova guinea">Nuova guinea</option>
					<option value="Paraguay">Paraguay</option>
					<option value="Peru">Peru'</option>
					<option value="Polonia">Polonia</option>
					<option value="Porto Rico">Porto Rico</option>
					<option value="Portogallo">Portogallo</option>
					<option value="Principato di Monaco">Principato di Monaco</option>
					<option value="Qatar">Qatar</option>
					<option value="Regno Unito">Regno Unito</option>
					<option value="Repubblica Ceca">Repubblica Ceca</option>
					<option value="Repubblica Centrafricana">Repubblica Centrafricana</option>
					<option value="repubblica del Congo">repubblica del Congo</option>
					<option value="San Marino">San Marino</option>
					<option value="Repubblica Dominicana">Repubblica Dominicana</option>
					<option value="Romania">Romania</option>
					<option value="Ruanda">Ruanda</option>
					<option value="Russia">Russia</option>
					<option value="Sahara Occidentale">Sahara occidentale</option>
					<option value="Samoa">Samoa</option>
					<option value="Santa lucia">Santa Lucia</option>
					<option value="Senegal">Senegal</option>
					<option value="Serbia">Serbia</option>
					<option value="Seychelles">Seychelles</option>
					<option value="Sierra Leone">Sierra Leone</option>
					<option value="Singapore">Singapore</option>
					<option value="Siria">Siria</option>
					<option value="Slovacchia">Slovacchia</option>
					<option value="Slovenia">Slovenia</option>
					<option value="Somalia">Somalia</option>
					<option value="Spagna">Spagna</option>
					<option value="Sri Lanka">Sri Lanka</option>
					<option value="Stati Uniti d'America">Stati Uniti d'America</option>
					<option value="Sud Africa">Sud Africa</option>
					<option value="Sudan">Sudan</option>
					<option value="Suriname">Suriname</option>
					<option value="Svezia">Svezia</option>
					<option value="Svizzera">Svizzera</option>
					<option value="Swaziland">Swaziland</option>
					<option value="Tagikistan">Tagikistan</option>
					<option value="Tailandia">Tailandia</option>
					<option value="Taiwan">Taiwan</option>
					<option value="Tanzania">Tanzania</option>
					<option value="Togo">Togo</option>
					<option value="Tonga">Tonga</option>
					<option value="Tunisia">Tunisia</option>
					<option value="Turchia">Turchia</option>
					<option value="Turkmenistan">Turkmenistan</option>
					<option value="Tuvalu">Tuvalu</option>
					<option value="Ucraina">Ucraina</option>
					<option value="Uganda">Uganda</option>
					<option value="Ungheria">Ungheria</option>
					<option value="Uruguay">Uruguay</option>
					<option value="Uzbekistan">Uzbekistan</option>
					<option value="Vanuatu">Vanuatu</option>
					<option value="Venezuela">Venezuela</option>
					<option value="Vietnam">Vietnam</option>
					<option value="Yemen">Yemen</option>
					<option value="Zambia">Zambia</option>
					<option value="Zimbabwe">Zimbabwe</option>
				</select>
				<select class="seleziona" name="provincia">
					<option value="" selected="">Seleziona</option>
					<option value="Agrigento">Agrigento</option>
					<option value="Alessandria">Alessandria</option>
					<option value="Ancona">Ancona</option>
					<option value="Aosta">Aosta</option>
					<option value="Arezzo">Arezzo</option>
					<option value="Ascoli Piceno">Ascoli Piceno</option>
					<option value="Asti">Asti</option>
					<option value="Avellino">Avellino</option>
					<option value="Bari">Bari</option>
					<option value="Belluno">Belluno</option>
					<option value="Benevento">Benevento</option>
					<option value="Bergamo">Bergamo</option>
					<option value="Biella">Biella</option>
					<option value="Bologna">Bologna</option>
					<option value="Bolzano">Bolzano</option>
					<option value="Brescia">Brescia</option>
					<option value="Brindisi">Brindisi</option>
					<option value="Cagliari">Cagliari</option>
					<option value="Caltanissetta">Caltanissetta</option>
					<option value="Campobasso">Campobasso</option>
					<option value="Caserta">Caserta</option>
					<option value="Catania">Catania</option>
					<option value="Catanzaro">Catanzaro</option>
					<option value="Chieti">Chieti</option>
					<option value="Como">Como</option>
					<option value="Cosenza">Cosenza</option>
					<option value="Cremona">Cremona</option>
					<option value="Crotone">Crotone</option>
					<option value="Cuneo">Cuneo</option>
					<option value="Enna">Enna</option>
					<option value="Ferrara">Ferrara</option>
					<option value="Firenze">Firenze</option>
					<option value="Foggia">Foggia</option>
					<option value="Forlì - Cesena">Forlì - Cesena</option>
					<option value="Frosinone">Frosinone</option>
					<option value="Genova">Genova</option>
					<option value="Gorizia">Gorizia</option>
					<option value="Grosseto">Grosseto</option>
					<option value="Imperia">Imperia</option>
					<option value="Isernia">Isernia</option>
					<option value="La Spezia">La Spezia</option>
					<option value="L'Aquila">L'Aquila</option>
					<option value="Latina">Latina</option>
					<option value="Lecce">Lecce</option>
					<option value="Lecco">Lecco</option>
					<option value="Livorno">Livorno</option>
					<option value="Lodi">Lodi</option>
					<option value="Lucca">Lucca</option>
					<option value="Macerata">Macerata</option>
					<option value="Mantova">Mantova</option>
					<option value="Massa Carrara">Massa Carrara</option>
					<option value="Materna">Matera</option>
					<option value="Messina">Messina</option>
					<option value="Milano">Milano</option>
					<option value="Modena">Modena</option>
					<option value="Napoli">Napoli</option>
					<option value="Novara">Novara</option>
					<option value="Nuoro">Nuoro</option>
					<option value="Oristanio">Oristano</option>
					<option value="PD">Padova</option>
					<option value="Palermo">Palermo</option>
					<option value="Parma">Parma</option>
					<option value="Pavia">Pavia</option>
					<option value="Perugia">Perugia</option>
					<option value="Pesaro">Pesaro</option>
					<option value="Pescara">Pescara</option>
					<option value="Piacenza">Piacenza</option>
					<option value="Pisa">Pisa</option>
					<option value="Pistoia">Pistoia</option>
					<option value="Pordenone">Pordenone</option>
					<option value="Potenza">Potenza</option>
					<option value="Prato">Prato</option>
					<option value="Ragusa">Ragusa</option>
					<option value="Ravenna">Ravenna</option>
					<option value="Reggio Calabria">Reggio Calabria</option>
					<option value="Reggio Emilia">Reggio Emilia</option>
					<option value="Rieti">Rieti</option>
					<option value="Rimini">Rimini</option>
					<option value="Roma">Roma</option>
					<option value="Rovigo">Rovigo</option>
					<option value="Salerno">Salerno</option>
					<option value="Sassari">Sassari</option>
					<option value="Savona">Savona</option>
					<option value="Siena">Siena</option>
					<option value="Siracusa">Siracusa</option>
					<option value="Sondrio">Sondrio</option>
					<option value="Taranto">Taranto</option>
					<option value="Teramo">Teramo</option>
					<option value="Terni">Terni</option>
					<option value="Torino">Torino</option>
					<option value="Trapani">Trapani</option>
					<option value="Trento">Trento</option>
					<option value="Treviso">Treviso</option>
					<option value="Trieste">Trieste</option>
					<option value="Udine">Udine</option>
					<option value="Varese">Varese</option>
					<option value="Venezia">Venezia</option>
					<option value="Verbania-Cusio-Ossola">Verbania-Cusio-Ossola</option>
					<option value="Vercelli">Vercelli</option>
					<option value="Verona">Verona</option>
					<option value="Vibo Valentia">Vibo Valentia</option>
					<option value="Vicenza">Vicenza</option>
					<option value="Viterbo">Viterbo</option>
				</select>
			</div>
			<div id="nazione2">
				<label><?php echo $enazione?></label>
			</div>
			<div>
				<input type="tel" name="numeroutente" value="<?php echo $vtelefono?>" placeholder="Telefono -01234567890" pattern="[0-9]{10}" ></input>
				<input type="text" name="cittautente" placeholder="Comune" value="<?php echo $vcitta?>"></input>	
			</div>
			<div id="numero">
				<label><?php echo $enumero?></label>
				<label><?php echo $ecitta?></label>
			</div>
			<div>
				<input type="password" name="password" placeholder="Password" ></input>	
				<input type="password" name="passwordconf" placeholder="Conferma la password" ></input>
			</div>
			<div id="password">
				<label><?php echo $epassword?></label>
			</div>
			<input type="submit" name="registrati" id="registrari" value="Registrati"></input>
		</form>
	</div>
	
	<!--<div class="alert">
		<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>This is an alert box.
		<img src="img/registrato.gif">
	</div>-->	
	<!--<img src="animation.gif" alt="funny animation GIF">
		https://mailtrap.io/blog/php-email-sending/ <-- includere mail trap
	-->
</body>
</html>