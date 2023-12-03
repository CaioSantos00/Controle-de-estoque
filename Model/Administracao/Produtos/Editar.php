<?php
	namespace Administracao\Produtos;

	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\Model;
	use App\Exceptions\UserException;

	class Editar implements Model{
		private array $dadosPrimarios;
		private array $dadosSecundarios;
		private array $dadosErrados;
		private array $queries = [
			"primario" =>
				"update `produtoprimario`
				set `Nome` = :nome, `Classificacoes` = :classificacoes
				where `Id` = :Id",
			"secundario" =>
				"update `produtosecundario`
				set `preco/peca` = :preco, `qtd` = :qtd, `Disponibilidade` = :disponibilidade,
				`especificacoes` = :especificacoes
				where `Id` = :Id and `ParentId` = :ParentId"
		]
		function __construct(array $dadosPrimarios, array $dadosSecundarios){
			$this->dadosPrimarios = $dadosPrimarios;
			$this->dadosSecundarios = $dadosSecundarios;
		}
		private function salvaDadosPrimarios() :bool{
			try{
				$resultado = true;
					$query = CB::getConexao()->prepare($this->queries["primario"]);
					if(!$query->execute($this->dadosPrimarios)) throw new UserException("erro interno");
			}
			catch(UserException $e){
				$resultado = false;
			}
			catch(\PDOException|\Exception $e){
				$GLOBALS['ERRO']->setErro("Edição de produto", "no pdo: {$e->getMessage()}");
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}		
		private function salvaDadosSecundarios() :bool{
			try{
				$resultado = true;				
				$query = CB::getConexao()->prepare($this->queries["secundario"]);
				foreach($this->dadosSecundarios as $dado){
					$query->execute($dado);
					if($query->rowCount == 0) $this->dadosErrados[] = $dado['Id'];
				}
				if(count($errados) != 0) throw new UserException("dados errados");
			}
			catch(UserException $e){
				$resultado = false;
			}
			catch(\PDOException|\Exception $e){
				$GLOBALS['ERRO']->setErro("Edição de produto", $e->getMessage());
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
		function getResposta(){
			try{
				CB::getConexao()->beginTransaction();
				if(!$this->salvaDadosPrimarios())
					throw new \Exception("erro interno");
				if(!$this->salvaDadosSecundarios())
					throw new \Exception("erro interno");
				CB::getConexao()->commit();
				return true;
			}
			catch(\Exception $e){
				CB::voltaTudo();
				return false;
			}
		}
	}