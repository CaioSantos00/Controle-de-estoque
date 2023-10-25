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
			$this->classificacaoParaExcluir = $qual;
		}
		private function getTodosDoBanco() :\PDOStatement{
			CB::getConexao()->beginTransaction();
				$select = CB::getConexao()->query($this->querys[0]);
				if(is_bool($select)) throw new \Exception("na consulta de classificacoes no banco");
			CB::getConexao()->commit();
			return $select;
		}
		private function resetarIndicesArrayBaseadoEmOutro(array $array1, array $array2){
			$x = 0; $linhaDeClassesComIndicesResetados = [];

			$linhaDeClasses = array_diff($array1,[$array2]);
			foreach($linhaDeClasses as $valor) $linhaDeClassesComIndicesResetados[$x++] = $valor;
			return $linhaDeClassesComIndicesResetados;
		}
		private function encontraApenasOsComAClassificacao(\PDOStatement $resultadoConsulta) :array{
			$paraAlterar = [];
			foreach($resultadoConsulta as $linha){
				$classes = json_decode($linha['Classificacoes']);
				foreach($classes as $classi){
					if($classi == $this->classificacaoParaExcluir) {
						$paraAlterar[] = [$this->resetarIndicesArrayBaseadoEmOutro($classes, $classi), $linha['Id']];
					}
				}
			}
			return $paraAlterar;
		}
		private function alteraArquivo(){
			$this->classificacoesSalvas = array_diff(
				$this->classificacoesSalvas, [$this->classificacaoParaExcluir]
			);
		}
		private function alteraOsQuePrescisa(array $paraAlterar){
			CB::getConexao()->beginTransaction();
				$query = CB::getConexao()->prepare($this->querys[1]);
				foreach($paraAlterar as $linha){
					if($query->execute($linha) === false) throw new \Exception("deu errado na alteração do banco");
				}
			CB::getConexao()->commit();
		}
		private function executarQuerys() :bool{
			try{
				$resultado = true;
				$dados = $this->getTodosDoBanco();
				$dadosComClassificacaoAlteravel =
					$this->encontraApenasOsComAClassificacao($dados);
				$this->alteraOsQuePrescisa($dadosComClassificacaoAlteravel);
				$this->alteraArquivo();
			}
			catch(\PDOException|\Exception $ex){
				$GLOBALS['ERRO']->setErro("Excluir Classificações", "nas das querys, {$ex->getMessage()}");
				if(CB::getConexao()->inTransaction()){
					CB::getConexao()->rollBack();
					CB::getConexao()->commit();
				}
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
		function executar(){
			if($this->executarQuerys()) return "tudo certo";
			return "algo deu errado";
		}
	}