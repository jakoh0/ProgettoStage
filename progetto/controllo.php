<?php 
	function controllo_citta($citta){
		$citta= trim($citta);
		$myFile = fopen("comuniitalia.txt","r") or die("impossibile aprire il file");
		while(!feof($myFile)){
			if(strcmp(trim(strtoupper(fgets($myFile))),strtoupper($citta))==0){
				return true;
				break;
			}
		}
		fflush($myFile);
		fclose($myFile);
		/* RETURN TRUE O ECHO QUALCOSA */ 
		
	}
?>