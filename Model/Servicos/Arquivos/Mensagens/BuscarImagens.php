<?php
	namespace App\Servicos\Arquivos\Mensagens;

	use App\Interfaces\ServicoInterno;

	class BuscarImagens implements ServicoInterno{
		private const DIRETORIO_BASE = "arqvsSecundarios/Mensagens/";
		private string $idMensagem;
		private array $cacheImagens = [];
	
		public function setIdMsg(string $idMensagem){
			$this->idMensagem = $idMensagem;
		}
	
		private function buscarArquivos(string $diretorio): array{
			if(array_key_exists($this->idMensagem, $this->cacheImagens))
				return $this->cacheImagens[$this->idMensagem];
	
			if(is_dir($diretorio)){				
				$this->cacheImagens[$this->idMensagem] = array_diff(scandir($diretorio),['.', '..']);
				return $this->buscarArquivos($diretorio);
			}	
			return [];
		}
	
		public function getImagens(): array{
			return $this->cacheImagens[$this->idMensagem] ?? [];
		}
	
		public function executar(){
			$diretorioCompleto = self::DIRETORIO_BASE . $this->idMensagem;
			$this->cacheImagens[$this->idMensagem] = $this->buscarArquivos($diretorioCompleto);
		}
	}