<?php
	namespace App\Produtos\Variacoes;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\ServicoInterno as ServicoInterno;
	
	class ConsultaUnica implements ServicoInterno{
		private string $idVariacao;
		private array $dadosParaBuscar;
		private string $query = "select >>><<< from `Produtosecundario` where `Id` = ?";
		function __construct(string $idVariacao, array $dadosParaBuscar){
			$this->idVariacao = $idVariacao;
			$this->dadosParaBuscar = $dadosParaBuscar;
		}
		private function prepararQuery() :string{
			if($this->dadosParaBuscar[0] == "*") return str_replace(">>><<<","*",$this->query);
			$parametros = "";
			foreach($this->dadosParaBuscar as $dado){	
				$parametros .= "`$dado`,";
			}
			$parametros[(strlen($parametros) - 1)] = " ";
			return str_replace(">>><<<",$parametros,$this->query);
		}
		private function getDadosBanco() :array{
			try{
				$resultados = [];
				CB::getConexao()->beginTransaction();
					$resultados = CB::getConexao()->prepare($this->prepararQuery());
					$resultados->execute([$this->idVariacao]);
					$resultados = $resultados->fetchAll();
				CB::getConexao()->commit();
			}
			catch(\Exception|\PDOException $e){
				CB::voltaTudo();
				$GLOBALS['ERRO']->setErro("Consulta variação", "na consulta de dados da variação {$this->idVariacao}, {$e->getMessage()}");
				$resultados = [];
			}
			finally{
				return $resultados;
			}
		}
		private function retornarDadosEscolhidosParaBuscar() :array{
			$dados = $this->getDadosBanco();
			$resultado = [];
			foreach($dados as $dado){
				foreach($this->dadosParaBuscar as $paraReceber){
					$resultado[$paraReceber] = $dado[$paraReceber];
				}
			}
			return $resultado;
		}
		function executar(){
			return $this->retornarDadosEscolhidosParaBuscar();
		}
	}