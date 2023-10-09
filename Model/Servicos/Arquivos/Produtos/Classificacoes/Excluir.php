<?php
	namespace App\Servicos\Arquivos\Produtos\Classificacoes;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Servicos\Arquivos\Produtos\Classificacoes\Classificacoes;
	use App\Interfaces\ServicoInterno;
	
	class Excluir extends Classificacoes implements ServicoInterno{
		private string $classificacaoParaExcluir;
		private array $querys;
		function __construct(string $qual){
			parent::__construct();
			$this->querys = [
				"select `Id`,`Classificacoes` from `produtoprimario`",
				"update `produtoprimario` set `Classificacoes` = ? where `Id` = ? "
			];
		}		
		private function getTodosDoBanco(){
			CB::getConexao()->beginTransaction();
				$select = CB::getConexao()->query($this->querys[0]);
				if(is_bool($select)) throw new \Exception("na consulta de classificacoes no banco");
			CB::getConexao()->commit();
			return $select;
		}
		private function encontraApenasOsComAClassificacao(\PDOStatement $resultadoConsulta) :array{
			$paraAlterar = [];
			foreach($resultadoConsulta as $linha){
				$classes = json_decode($linha['Classificacoes']);
				foreach($classes as $classi){
					if($classi == $this->classificacaoParaExcluit) {
						unset($classi);
						$paraAlterar[] = [json_encode($classes), $linha['Id']];
					}					
				}				
			}
			return $paraAlterar;
		}
		private function alteraOsQuePrescisa(array $paraAlterar){
			CB::getConexao()->beginTransaction();
				$query = CB::getConexao()->prepare($this->querys[1]);
				foreach($paraAlterar as $linha){
					if($query->execute($linha) === false) throw new Exception("deu errado na alteração do banco");
				}
			CB::getConexao()->commit();
		}
		private function executarQuerys(){
			try{
				$this->alteraOsQuePrescisa(
					$this->encontraApenasOsComAClassificacao(
						$this->getTodosDoBanco()
					)
				);
				$resultado = true;
			}
			catch(\PDOException $ex){
				$GLOBALS['ERRO']->setErro("Excluir Classificações", "na execução das querys, {$ex->getMessage()}");
				if(CB::getConexao()->inTransaction()) CB::getConexao()->rollBack();
				$resultado = false;
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro("Excluir Classificações", "na consulta das querys, {$ex->getMessage()}");
				if(CB::getConexao()->inTransaction()) CB::getConexao()->rollBack();
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
		function executar(){
			return $this->executarQuerys();
		}
	}