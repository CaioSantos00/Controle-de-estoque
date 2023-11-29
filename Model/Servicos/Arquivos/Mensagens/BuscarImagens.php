<?php
	namespace App\Servicos\Arquivos\Mensagens;

	use App\Interfaces\ServicoInterno;

	class BuscarImagens implements ServicoInterno{
		private string $dir = "arqvsSecundarios/Mensagens/";
		private string $idMensagem;
		public array $imagens;
		private array $cacheImagens = [];

		private function buscarArquivos(string $diretorio) :array{
			if(array_key_exists($this->idMensagem, $this->cacheImagens))
				return $this->cacheImagens[$this->idMensagem];
			$this->cacheImagens[$this->idMensagem] = array_diff(['.','..'],scandir($diretorio));
			return $this->buscarArquivos($diretorio);
		}
		function setIdMsg(string $idMensagem){
			$this->idMensagem = $idMensagem;
		}
		function executar(){
			$dir = $this->dir.$this->idMensagem;
			$this->imagens = [];
			if(file_exists($dir))
				$this->imagens = $this->buscarArquivos($dir);
		}
	}