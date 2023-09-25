<?php
	namespace App\Servicos\ErrorLogging;	
	
	class ErrorLogging{
		const LOG_LOCATION = "ServerInfo/LogErros.txt";
		const SEPARADOR_DE_ERROS = "<<<>>>";
		public $logDeErros;
		static bool $logInstanciado;
		
		function __construct(){
			$this->setLogErros();			
		}		
		private function setLogErros(){
			if(empty($this->logDeErros)){
				$this->logDeErros = fopen(self::LOG_LOCATION, 'a');
				//var_dump(scandir("./"));
				self::$logInstanciado = true;				
				if(!$this->logDeErros) self::$logInstanciado = false;
			}
		}
		function criarLinhaDeErro(string $onde, string $mensagem) :string{
			$linhaDeErro = array(
			"quando"	=> date('d-m-y \a\s h:i',strtotime('now')),
			"onde"		=> $onde,
			"mensagem" 	=> $mensagem
			);
			return self::SEPARADOR_DE_ERROS.json_encode($linhaDeErro)."\n";
		}
		function setErro(string $onde, string $mensagem){			
			if(self::$logInstanciado) fwrite($this->logDeErros, $this->criarLinhaDeErro($onde, $mensagem));			
		}

		function __destruct(){
			if(self::$logInstanciado){
				fclose($this->logDeErros);
				self::$logInstanciado = false;			
			}
		}
	}
	