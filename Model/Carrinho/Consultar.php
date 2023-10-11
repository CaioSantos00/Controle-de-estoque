<?php
	namespace App\Carrinho;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\ServicoInterno;
	use App\Interfaces\Model;
	
	class Consultar implements Model,ServicoInterno, Stringable{
		private string $query = "select `Carrinho` from `Usuario` where `Id` = ?";
		protected string $idUsuario;
		private array $carrinho;
		function executar(string $idUsuario){
			$this->idUsuario = $idUsuario;
		}
		private function consultarBanco() :array{
			try{
				CB::getConexao()->beginTransaction();
				$carrinho = CB::getConexao()->prepare($this->query)->execute($this->idUsuario);			
				CB::getConexao()->commit();
			}
			catch(\Exception|\PDOException $e){
				if(CB::getConexao()->inTransaction()) CB::getConexao->rollBack();
				$carrinho = [false];
			}
			finally{
				return array_shift($carrinho);
			}
		}
		function __toString(){
			return json_encode($this->getResposta());
		}
		function getResposta() :array{
			if(empty($this->carrinho)) $this->carrinho = $this->consultarBanco();
			return $this->carrinho;
		}
	}