<?php
	namespace App\Servicos\Arquivos\Produtos\Descricoes;

	use App\Interfaces\ServicoInterno;

	class CriarDescricao implements ServicoInterno{
		private string $idProduto;
		private string $descricao;		
		function setDados(string $idProduto, string $descricao){
			$this->idProduto = $idProduto;
			$this->descricao = $descricao;
		}
		private function criaArquivo(string $descricao){
			file_put_contents(
				"arqvsSecundarios/Produtos/Descricoes/{$this->idProduto}.txt",
				$descricao
			);
		}
		function executar(){
			$this->criaArquivo($this->descricao);
		}
	}
