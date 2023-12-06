<?php
	namespace App\Produtos;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\ServicoInterno;
	
	class ConsultaPrimarios implements ServicoInterno{
		const QUERY = "select * from `produtoprimario`";
		private array $primarios = [];
		private function getDadosBanco() :array{
			try{
				$query = CB::getConexao()->query(self::QUERY);
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
		function executar(){
			$this->primarios = $this->organizaDadosDoBanco(
				$this->getDadosBanco()
			);
		}
	}