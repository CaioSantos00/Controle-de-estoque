<?php
	namespace App\Produtos;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\ServicoInterno;
	
	class ConsultaPrimarios implements ServicoInterno{
		private string $query = "select * from `produtoprimario`";
		private array $primarios = [];
		private function getDadosBanco() :array{
			try{
				$query = CB::getConexao()->query($this->query);
				return $query->fetchAll();
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro("Consulta de primários", $e->getMessage());
				return [];
			}
		}
		private function organizaDadosDoBanco(array $resultadoConsulta) :array{
			$resultados = [];
			foreach($resultadoConsulta as $linha)
				$resultados[] = [
					"Id" => $linha["Id"],
					"Nome" => $linha["Nome"],
					"Classificacoes" => json_decode($linha['Classificacoes'], true)
				];
			return $resultados;
		}		
		function getPrimarios() :array{
			return $this->primarios;
		}
		function setEspecificos(array $quais){
			$ids = implode(",", $quais);
			$this->query .= " where `Id` in ({$ids}}";
		}
		function executar(){
			$this->primarios = $this->organizaDadosDoBanco(
				$this->getDadosBanco()
			);
		}
	}