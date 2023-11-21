<?php
	namespace App\Servicos\Arquivos\Produtos\Descricoes;
	use App\Interfaces\ServicoInterno;
	
	class ExcluirDescricao implements ServicoInterno{
		private string $nomeArquivoDescricao;
		function __construct(string $idProduto){
			$this->nomeArquivoDescricao = $idProduto.".txt";
		}
		private function verificarSeDescricaoExiste() :bool{
			$todasDescricoes = array_diff(
				scandir("arqvsSecundarios/Produtos/Descricoes"),
				['.','..']
			);
			foreach($todasDescricoes as $descricao){
				if($descricao == $this->nomeArquivoDescricao) return true;
			}
			return false;
		}
		private function excluirArquivo() :bool{
			return unlink("arqvsSecundarios/Produtos/Descricoes/{$this->nomeArquivoDescricao}");
		}
		function executar() :bool{
			if($this->verificarSeDescricaoExiste()) return $this->excluirArquivo();
			return false;			
		}
	}