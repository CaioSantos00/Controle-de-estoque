<?php
	namespace App\Enderecos;

    use App\Servicos\Conexao\ConexaoBanco as CB;
    use App\Interfaces\Model;
	use App\Exceptions\UserException;

    class Consultar implements Model{
        private string $idUsuario;
        private array $resultadoConsulta;
        private string $query;
        function __construct(string $idUsuario, string $buscarPor = "IdDono"){
            $this->idUsuario = $idUsuario;
			$this->query = "select
	            `Id`,`nomeEndereco`,`Cep`,`Cidade`,`Rua`,`Bairro`,`Numero`,
	            `DataCriacao`,`InstrucoesEntrega`,`dataModificacao`
	            from `enderecos` where `{$buscarPor}` = ?";
        }		
		private function separaDadosDoBanco(array &$resul, array $resultadoDaConsulta){
			$x = 0;
			foreach($resultadoDaConsulta as $consulta){
				$resul[$x] = [];
				foreach($consulta as $chav => $valor){
					if(!is_string($chav)) continue;
					$resul[$x][] = $valor;
				}
				$x++;
			}
		}
		/*
			"Id" => $consulta["Id"],
			"nomeEndereco" => $consulta["nomeEndereco"],
			"Cep" => $consulta["Cep"],
			"Cidade" => $consulta["Cidade"],
			"Rua" => $consulta["Rua"],
			"Bairro" => $consulta["Bairro"],
			"Numero" => $consulta["Numero"],
			"DataCriacao" => $consulta["DataCriacao"],
			"InstrucoesEntrega" => $consulta["InstrucoesEntrega"],
			"dataModificacao" => $consulta["dataModificacao"]
		*/
        private function consultarBanco() :array{
            try{
                $resultado = [];
                $query = CB::getConexao()->prepare($this->query);
        		if(!$query->execute([$this->idUsuario])) throw new \Exception("execução da query falhou");
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
            if(empty($this->resultadoConsulta))
				$this->resultadoConsulta = $this->consultarBanco();
            return $this->resultadoConsulta;
        }
    }
