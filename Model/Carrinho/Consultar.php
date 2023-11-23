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
			if(empty($this->carrinho)) $this->carrinho = $this->consultarBanco();
		}
		private function consultarBanco() :array{
			try{
				$retorno = [];
				$carrinhos = CB::getConexao()->prepare($this->query);
				$carrinhos->execute([$this->idUsuario]);
				$carrinhos = $carrinhos->fetchAll();
				$retorno = count($carrinhos) > 0
					? json_decode($carrinhos[0]['Carrinho'], 1)
					: [];
			}
			catch(\Exception $e){
				CB::voltaTudo();
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
			return $this->carrinho;
		}
	}
