<?php
	namespace App\Interfaces;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	
	abstract class Consulta{
		protected array $queriesConsulta = [
			"select `Id`, `Nome`, `Classificacoes` from `ProdutoPrimario`",
            "select `Id`, `Preco`, `Qtd`, `Disponibilidade`, `Descricao` from `produtossecundario` where `Id` = ?"
		];
		protected function buscarDadosPrincipaisDoBanco(ServicoInterno $consultaImagens) :array|false{
            try{
                $resultados = [];
                
                CB::getConexao()->beginTransaction();
                    $primarios = CB::getConexao()->query($this->queriesConsulta[0]);
                    $buscaSecundarios = CB::getConexao()->prepare($this->queriesConsulta[1]);
                    foreach($primarios as $primario){
                        $resultados[] = [
                            $buscaSecundarios->execute([$primario['Id']]),
                            ...$primario,
                            $this->getFotos($primario['Id'], $consultaImagens)
                        ];
                    }
                CB::getConexao()->commit();
            }
            catch(\Exception|\PDOException $ex){
                if(CB::getConexao()->inTransaction()) CB::getConexao()->rollBack();
                $GLOBALS['ERRO']->setErro("Consulta produto", "na busca dos dados no banco, {$ex->getMessage()}");
                $resultados = false;
            }
            finally{
                return $resultados;
            }			
        }
		private function getFotos(string $idProdutoPrimario, ServicoInterno $consUniq){
            return $consUniq->executar($idProdutoPrimario);
        }
		abstract protected function setParametroConsultaPrincipal();
	}