<?php
	namespace App\Servicos;

	class ErrorLogging{
		const LOG_LOCATION = "ServerInfo/LogErros.txt";
		const SEPARADOR_DE_ERROS = "<<<>>>";
		static bool $erroFatal = false;
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
		function criarLinhaDeErro(string $onde, string|array $mensagem) :string{
			$linhaDeErro = array(
				"quando"	=> date('d-m-y \a\s h:i',strtotime('now')),
				"onde"		=> $onde,
				"mensagem" 	=> $mensagem
			);
			return self::SEPARADOR_DE_ERROS.json_encode($linhaDeErro)."\n";
		}
		function setErro(string $onde, string|array $mensagem){
			if(!self::$logInstanciado) return;
			$escrita = fwrite(
				$this->logDeErros,
				$this->criarLinhaDeErro($onde, $mensagem)
			);
			if(!$escrita) self::$erroFatal = true;
		}        
		function cancela(Exception $e){
			throw $e;	
		}		
		function __construct(){
			$this->setLogErros();
		}
		function __toString(){
            return file_get_contents(self::LOG_LOCATION);
        }
		function __destruct(){
			if(self::$logInstanciado){
				if(!fclose($this->logDeErros)) $this->setErro('Gerenciador de erros', 'O ponteiro de arquivo não fechou');
				self::$logInstanciado = false;
			}
		}
	}
