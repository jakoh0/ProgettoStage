<?php	
	class Veicolo{
		private $marca;
		private $carburante;
		private $carburante_iniziale;
		private $metri;
		
		function __construct($nome,$stato_c){
			$this ->marca = $nome;
			$this ->carburante= $stato_c;
			$this ->carburante_iniziale= $stato_c;
		} 
		
		function stampa(){
			echo "Veicolo: ".$this ->marca. "<br>Metri percorsi: ".$this -> metri."<br>Stato carburante: ".$this ->carburante."<br>";
			echo "______________________________________________________________________________________________________________________<br>";
		}
		
		public function run(){
			$this -> carburante -= rand(4,15);
			$this -> metri += rand(5,15);
		}
		
		public function stato_carburante(){
			if($this -> carburante <0){
				$this ->carburante=0;
			}
			return $this ->carburante;
		}
		
		public function vincitore(){
			return $this -> metri;
		}
		
	}
?>