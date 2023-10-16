<?php
	namespace App\Carrinho;

	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\Model;

	class Consultar implements Model, \Stringable{
		private string $query = "select `Carrinho` from `usuario` where `Id` = ?";
		protected string $idUsuario;
		private array $carrinho;
		function __construct($idUsuario){
			$this->idUsuario = $idUsuario;
		}
		function executar(string $idUsuario){
			$this->idUsuario = $idUsuario;
		}
		private function consultarBanco() :string{
			try{
				CB::getConexao()->beginTransaction();
				$carrinhos = CB::getConexao()->prepare($this->query);
				$carrinhos->execute([$this->idUsuario]);
				$retorno = $carrinhos->fetchAll()[0]['Carrinho'];
				CB::getConexao()->commit();
			}
			catch(\Exception $e){
				if(CB::getConexao()->inTransaction()) CB::getConexao->rollBack();
				$GLOBALS['ERRO']->setErro("Consulta de carrinho", $e->getMessage());
				CB::getConexao()->commit();
				$retorno = json_encode([]);
			}
			finally{
				return $retorno;
			}
		}
		function __toString(){
			return json_encode($this->getResposta());
		}
		function getResposta() :array{
			if(empty($this->carrinho)) $this->carrinho = json_decode($this->consultarBanco());
			return $this->carrinho;
		}
	}