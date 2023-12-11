<?php
	namespace App\Enderecos;

    use App\Servicos\Conexao\ConexaoBanco as CB;
    use App\Interfaces\Model;
	use App\Exceptions\UserException;
	use App\Traits\OrganizarDadosConsulta as ODC;
	
    class Consultar implements Model{
		use ODC;
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
        private function consultarBanco() :array{
            try{
                $resultado = [];
                $query = CB::getConexao()->prepare($this->query);
        		if(!$query->execute([$this->idConsulta])) throw new \Exception("execução da query falhou");
		        $resultadoConsulta = $query->fetchAll();
				if($resultadoConsulta === []) throw new UserException("sem enderecos cadastrados");
				$this->organizar($resultado, $resultadoConsulta);
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
