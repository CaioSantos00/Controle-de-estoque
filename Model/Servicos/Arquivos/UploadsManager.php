<?php
	namespace App\Servicos\Arquivos;

	abstract class UploadsManager{
		protected string $caminhoArqvsSecundarios = "arqvsSecundarios/";
		protected bool $resposta;
		
		protected function testarResposta(string $mensagemPraExcecao, bool $paraTestar = false){
			if($this->resultado === $paraTestar) throw new Exception($mensagemPraExcecao);
		}
		
		abstract function salvarImagemEnviada(); 
	}