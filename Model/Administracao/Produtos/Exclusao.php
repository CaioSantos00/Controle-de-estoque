<?php
	namespace App\Administracao\Produtos;

	use App\Interfaces\Model;
	use App\Servicos\Conexao\ConexaoBanco as CB;

	use App\Servicos\Produtos\Imgs\Excluir;
	use App\Servicos\Produtos\Descricoes\ExcluirDescricao;

	class Exclusao implements Model{
		private string $idProduto;
		private array $querys;
		function __construct(string $idProduto){
			$this->idProduto = $idProduto;
		}
		private function excluirImgs(){
			$excluir = new Excluir($this->idProduto, "todasDeste");
			$excluir->executar();
		}
		private function excluirDescricao(){
			$excluir = new ExcluirDescricao($this->idProduto);
			return $excluir->executar();
		}
		private function executaQueries(){
			try{
				CB::getConexao()->beginTransaction();
					$this->querys[0]->execute([$this->idProduto]);
					$this->querys[1]->execute([$this->idProduto]);
				CB::getConexao()->commit();
				$retorno = true;
			}
			catch(\Exception|\PDOException $e){
				$GLOBALS['ERRO']->setErro("Exclusão de produto", "Na execução das queries: {$e->getMessage()}");
				$retorno = false;
			}
			finally{
				return $retorno;
			}
		}
		private function preparaQueries(){
			try{
				$this->querys = [
					CB::getConexao()->prepare("delete * from `produtosecundario` where ´Id´ = ?"),
					CB::getConexao()->prepare("delete * from `produtoprimario` where `Id` = ?")
				];
				$retorno = true;
			}
			catch(\PDOException $e){
				$GLOBALS['ERRO']->setErro("Exclusão de produto", "Na preparação das queries: {$e->getMessage()}");
				$retorno = false;				
			}
			finally{
				return $retorno;
			}
		}		
		function getResposta(){
			$resultados = [
				$this->preparaQueries(),
				$this->executaQueries(),
				$this->excluirImgs(),
				$this->excluirDescricao()
			];
			return $resultados;
		}
	}
