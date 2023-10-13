<?php
	namespace App\Servicos\Arquivos\Produtos\Descricoes;
	
	use App\Interfaces\ServicoInterno;
	class CriarDescricao implements ServicoInterno{
		private string $idProduto;
		private string $descricao;
		function __construct(string $idProduto, string $descricao){
			$this->idProduto = $idProduto;
			$this->descricao = $descricao;
		}
		private function criaArquivo(string $descricao) :bool{			
			if(file_put_contents('arqvsSecundarios/Produtos/Descricoes/{$this->idProduto}.txt', $descricao) === false) return false;
			return true;
		}
		function executar() :bool{
			return $this->criaArquivo($this->descricao);
		}
	}