<?php
	namespace App\Servicos\Arquivos\Produtos\Classificacoes;

	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Servicos\Arquivos\Produtos\Classificacoes\Classificacoes;
	use App\Interfaces\ServicoInterno;
	use App\Exceptions\UserException;

	class Excluir extends Classificacoes implements ServicoInterno{
		private string $classificacaoParaExcluir;
		private array $querys = [
			"select `Id`,`Classificacoes` from `produtoprimario`",
			"update `produtoprimario` set `Classificacoes` = ? where `Id` = ? "
		];
		function __construct(string $qual){
			parent::__construct();
			$this->classificacaoParaExcluir = $qual;
		}
		private function getTodosDoBanco() :array{
				$select = CB::getConexao()->query($this->querys[0]);
				if(is_bool($select)) throw new \Exception("na consulta de classificacoes no banco");
			return $select->fetchAll();
		}
		private function encontraApenasOsComAClassificacao(array $resultadoConsulta) :array{
			$paraAlterar = [];
			foreach($resultadoConsulta as $linha){
				$classes = json_decode($linha['Classificacoes'], true);
				foreach($classes as $classi){
					if($classi == $this->classificacaoParaExcluir) {
						$classesParaSalvar = json_encode(array_values(array_diff($classes, [$this->classificacaoParaExcluir])),1);
						$paraAlterar[] = [$classesParaSalvar,$linha['Id']];
					}
				}
			}
			return $paraAlterar;
		}
		private function alteraArquivo(){
			$this->classificacoesSalvas = array_values(array_diff($this->classificacoesSalvas, [$this->classificacaoParaExcluir]));
		}
		private function verificaSeClassificacaoExiste(){
			if(!in_array($this->classificacaoParaExcluir,$this->classificacoesSalvas))
			 	throw new UserException("classificação não encontrada, atualize suas classificações e tente novamente");
		}
		private function alteraOsQuePrescisa(array $paraAlterar){
			CB::getConexao()->beginTransaction();
				$query = CB::getConexao()->prepare($this->querys[1]);
				foreach($paraAlterar as $linha){
					if($query->execute($linha) === false) throw new \Exception("deu errado na alteração do banco");
				}
			CB::getConexao()->commit();
		}
		private function executarQuerys() :bool|string{
			try{
				$resultado = true;
				$dadosDoBanco = $this->getTodosDoBanco();
				$dadosComClassificacaoAlteravel =
					$this->encontraApenasOsComAClassificacao($dadosDoBanco);
				$this->alteraOsQuePrescisa($dadosComClassificacaoAlteravel);
				$this->alteraArquivo();
			}
			catch(UserException $ex){
				$resultado = $ex->getMessage();
			}
			catch(\Exception $ex){
				$GLOBALS['ERRO']->setErro("Excluir Classificações", "nas das querys, {$ex->getMessage()}");
				CB::voltaTudo();
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
		function executar(){
			$response = $this->executarQuerys();

			return match(true){
				is_string($response) => $response,
				is_bool($response) and $response => "tudo certo",
				is_bool($response) and !$response => "algo deu errado",
				default => "algo inesperado ocorreu"
			};
		}
	}
