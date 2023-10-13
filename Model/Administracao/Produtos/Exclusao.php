<?php
	namespace App\Administracao\Produtos;

	use App\Interfaces\Model;
	use App\Servicos\Conexao\ConexaoBanco as CB;

	use App\Servicos\Arquivos\Produtos\Imgs\Excluir;
	use App\Servicos\Produtos\Descricoes\ExcluirDescricao;

	class Exclusao implements Model{
		private string $idProduto;
		private array $querys;
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
		private function executaQueries() :bool{
			try{				
					$this->querys[0]->execute([$this->idProduto]);
					$this->querys[1]->execute([$this->idProduto]);
				CB::getConexao()->commit();
				$retorno = true;
			}
			catch(\Exception|\PDOException $e){
				$GLOBALS['ERRO']->setErro("Exclusão de produto", "Na execução das queries: {$e->getMessage()}");
				if(CB::getConexao()->inTransaction()) CB::getConexao()->rollBack();
				$retorno = false;
			}
			finally{
				return $retorno;
			}
		}
		private function preparaQueries() :bool{
			try{
				CB::getConexao()->beginTransaction();
				$this->querys = [
					CB::getConexao()->prepare("delete * from `produtosecundario` where ´Id´ = ?"),
					CB::getConexao()->prepare("delete * from `produtoprimario` where `Id` = ?")
				];
				$retorno = true;
			}
			catch(\PDOException $e){
				$GLOBALS['ERRO']->setErro("Exclusão de produto", "Na preparação das queries: {$e->getMessage()}");
				if(CB::getConexao()->inTransaction()) CB::getConexao()->rollBack();
				$retorno = false;				
			}
			finally{
				return $retorno;
			}
		}		
		function getResposta() :array{
			$resultados = [
				$this->preparaQueries(),
				$this->executaQueries(),
				$this->excluirImgs(),
				$this->excluirDescricao()
			];
			return $resultados;
		}
	}
