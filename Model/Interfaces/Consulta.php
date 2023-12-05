<?php
	namespace App\Interfaces;

	use App\Servicos\Conexao\ConexaoBanco as CB;

	abstract class Consulta{
		protected array $queriesConsulta = [
			"select `Id`, `Nome`, `Classificacoes` from `ProdutoPrimario`",
            "select `Id`, `preco/peca` as `Preco`, `Qtd`, `Disponibilidade`, `especificacoes` from `produtosecundario` where `Id` = ?"
		];
		protected function buscarDadosPrincipaisDoBanco(ServicoInterno $consultaImagens) :array|bool{
            try{
				$primarios = CB::getConexao()->query($this->queriesConsulta[0]);
				$resultados = [];
				foreach($primarios as $primario)
					$resultados[] = array(
						"primarios" => $this->organizaDadosPrimarios($primario),
						"secundarios" 	=> $this->getDadosSecundariosDoBanco($primario['Id']),
						"fotos"			=>$this->getFotos($primario['Id'], $consultaImagens)
					);
            }
            catch(\Exception $ex){
                $GLOBALS['ERRO']->setErro("Consulta produto", "na busca dos dados no banco, {$ex->getMessage()}");
                $resultados = false;
            }
            finally{
                return $resultados;
            }
        }
		private function getDadosSecundariosDoBanco(string $idPrincipal){
			$secundarios = CB::getConexao()->prepare($this->queriesConsulta[1]);
			$secundarios->execute([$idPrincipal]);
			$secundarios = $secundarios->fetchAll();
			$dadosSecundarios = [];
			foreach($secundarios as $secundario) $dadosSecundarios[] = $this->organizaDadosSecundarios($secundario);

			return $dadosSecundarios;
		}
		private function organizaDadosPrimarios(array $primarioInteiro) :array{
			return [$primarioInteiro['Id'],$primarioInteiro['Nome'], $primarioInteiro['Classificacoes']];
		}
		private function organizaDadosSecundarios(array $secundarioInteiro) :array{
			return array(
					"Id" 	=> $secundarioInteiro['Id'],
					"Preco" => $secundarioInteiro['Preco'],
					"Qtd" 	=> $secundarioInteiro['Qtd'],
					"Disponibilidade" 	=> $secundarioInteiro['Disponibilidade'],
					"especificacoes" 		=> $secundarioInteiro['especificacoes']
			);
		}
		private function getFotos(string $idProdutoPrimario, ServicoInterno $consUniq){
			$consUniq->idProduto = $idProdutoPrimario;
			return $consUniq->executar();
        }
		abstract protected function setParametroConsultaPrincipal();
	}
