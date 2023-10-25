<?php
	namespace App\Carrinho;

	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\Model;

	class Consultar implements Model, \Stringable{
		private string $query = "select `Carrinho` from `usuario` where `Id` = ?";
		protected string $idUsuario;
		private array $carrinho;		
		function executar(string $idUsuario){
			$this->idUsuario = $idUsuario;
		}
		private function consultarBanco() :array{
			try{				
				CB::getConexao()->beginTransaction();
					$carrinhos = CB::getConexao()->prepare($this->query);
					$carrinhos->execute([$this->idUsuario]);					
					$retorno = $carrinhos->fetchAll();
					$GLOBALS['ERRO']->setErro("consulta do carrinho do home1", $retorno);
					if($retorno != []) $retorno = json_decode($retorno[0]['Carrinho']);
					$GLOBALS['ERRO']->setErro("consulta do carrinho do home2", $retorno);
				CB::getConexao()->commit();
			}
			catch(\Exception|\PDOException $e){
				if(CB::getConexao()->inTransaction()) CB::getConexao->rollBack();
				$GLOBALS['ERRO']->setErro("Consulta de carrinho", $e->getMessage());
				CB::getConexao()->commit();
				$retorno = [];
			}
			finally{
				return $retorno;
			}
		}
		function __toString(){
			return json_encode($this->getResposta());
		}		
		function getResposta(){
			if(empty($this->carrinho)) $this->carrinho = $this->consultarBanco();
			$GLOBALS['ERRO']->setErro("consulta do carrinho do home3", $this->carrinho);
			return $this->carrinho;
		}
	}