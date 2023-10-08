<?php
	namespace App\Servicos\Arquivos\Produtos\Descricoes;
	
	use App\Interfaces\ServicoInterno;
	
	class EditarDescricao implements ServicoInterno{
		private string $idProduto;
		private string $novoConteudo;
		
		function __construct(string $idProduto, string $novoConteudo){
			$this->idProduto = $idProduto;
		}
		private function salvarNovaDescricao(){
			if(file_put_contents("arqvsSecundarios/Produtos/Descricoes/{$this->idProduto}.txt",$this->novoConteudo) === false){
				return false;
			}
			return true;
		}
		function executar(){
			return $this->salvarNovaDescricao();
		}
	}