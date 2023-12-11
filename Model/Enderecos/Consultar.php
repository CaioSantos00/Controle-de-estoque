<?php
	namespace App\Enderecos;

    use App\Servicos\Conexao\ConexaoBanco as CB;
    use App\Interfaces\Model;
	use App\Exceptions\UserException;

    class Consultar implements Model{
        private string $idConsulta;
		private array $resultadosConsultas = [];
        private string $query;        
		function setNovaConsulta(string $idConsulta, string $buscarPor = "IdDono"){
            $this->idConsulta = $idConsulta;
			$this->query = "select
	            `Id`,`nomeEndereco`,`Cep`,`Cidade`,`Rua`,`Bairro`,`Numero`,
	            `DataCriacao`,`InstrucoesEntrega`,`dataModificacao`
	            from `enderecos` where `{$buscarPor}` = ?";			
		}
		private function separaDadosDoBanco(array &$resul, array $resultadoDaConsulta){
			$x = 0;
			foreach($resultadoDaConsulta as $consulta){
				$resul[$x] = new \stdClass;
				foreach($consulta as $chav => $valor){
					if(!is_string($chav)) continue;
					$resul[$x]->$chav = $valor;
				}
				$x++;
			}
		}	
        private function consultarBanco() :array{
            try{
                $resultado = [];
                $query = CB::getConexao()->prepare($this->query);
        		if(!$query->execute([$this->idConsulta])) throw new \Exception("execução da query falhou");
		        $resultadoConsulta = $query->fetchAll();
				if($resultadoConsulta === []) throw new UserException("sem enderecos cadastrados");
				$this->separaDadosDoBanco($resultado, $resultadoConsulta);
            }
			catch(UserException $e){
				$resultado = [$e->getMessage()];
			}
			catch(\Exception $ex){
                $GLOBALS['ERRO']->setErro("consulta de endereco", $ex->getMessage());
                $resultado = [];
            }
            finally{
                return $resultado;
            }
        }		
        function getResposta(){
            if(!array_key_exists($this->idConsulta, $this->resultadosConsultas))
				$this->resultadosConsultas[$this->idConsulta] = $this->consultarBanco();
            return $this->resultadosConsultas[$this->idConsulta];
        }
    }
