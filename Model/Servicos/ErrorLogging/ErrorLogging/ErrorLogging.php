<?php
	namespace App\Servicos\ErrorLogging\ErrorLogging;

	class ErrorLogging{
		const LOG_LOCATION = "ServerInfo/LogErros.txt";
		const SEPARADOR_DE_ERROS = "<<<>>>";
		private bool $travaAntiRecursividadeInfinita = true;
		public $logDeErros;
		static bool $logInstanciado = false;

		private function setLogErros() :bool{
			if(empty($this->logDeErros)){
				$this->logDeErros = fopen(self::LOG_LOCATION, 'a');
				self::$logInstanciado = true;
				if(!$this->logDeErros){
					self::$logInstanciado = false;
					return false;
				}
				return true;
			}
			if(!$this->logDeErros){
				self::$logInstanciado = false;
				return false;
			}			
			return true;
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
			if(self::$logInstanciado){
				fwrite(
					$this->logDeErros,
					$this->criarLinhaDeErro($onde, $mensagem)
				);
				return;
			}
			if($this->setLogErros()) $this->setErro($onde, $mensagem);
		}

		function __destruct(){
			if(self::$logInstanciado){
				if(!fclose($this->logDeErros)) $this->setErro('Gerenciador de erros', 'O ponteiro de arquivo não fechou');
				self::$logInstanciado = false;
			}
		}
	}
