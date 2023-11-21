<?php
	namespace App\Administracao\Produtos;

	use App\Interfaces\Model;
	use App\Servicos\Conexao\ConexaoBanco as CB;

	use App\Servicos\Arquivos\Produtos\Imgs\Excluir;
	use App\Servicos\Produtos\Descricoes\ExcluirDescricao;

	class Exclusao implements Model{
		private string $idProduto;
		function __construct(string $idProduto){
			$this->idProduto = $idProduto;
		}
		private function excluirImgs() :bool{
			$excluir = new Excluir($this->idProduto, "todasDeste");
			return $excluir->executar();
		}
		private function excluirDescricao() :bool{
			$excluir = new ExcluirDescricao($this->idProduto);
			return $excluir->executar();
		}
		private function excluirNoBanco() :bool{
			try{
				CB::getConexao()->beginTransaction();
					CB::getConexao()->p
				CB::getConexao()->commit();
			}
		}
		function getResposta(){
			if(!$this->excluirNoBanco()) return false;
			return $this->excluirImgs() and $this->excluirDescricao();
		}
	}
