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
				CB::getConexao()->beginTransaction();
					$query = CB::getConexao()->prepare($this->queries["primario"]);
					if(!$query->execute($this->dadosPrimarios)) throw new UserException("erro interno");
				CB::getConexao()->commit();
			}
			catch(UserException $e){
				CB::voltaTudo();
				$resultado = false;
			}
			catch(\PDOException|\Exception $e){
				CB::voltaTudo();
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
				CB::getConexao()->beginTransaction();
				$query = CB::getConexao()->prepare($this->queries["secundario"]);
				foreach($this->dadosSecundarios as $dado){
					$query->execute($dado);
					if($query->rowCount == 0) $this->dadosErrados[] = $dado['Id'];
				}
				CB::getConexao()->commit();
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
			
		}
	}