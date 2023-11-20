<?php
	namespace App\Enderecos;

    use App\Servicos\Conexao\ConexaoBanco as CB;
    use App\Interfaces\Model;

    class Consultar implements Model{
        private string $idUsuario;
        private array $resultadoConsulta;        
        private string $query = "select 
            `Id`,`nomeEndereco`,`Cep`,`Cidade`,`Rua`,`Bairro`,`Numero`,
            `DataCriacao`,`InstrucoesEntrega`,`dataModificacao` 
            from `enderecos` where `IdDono` = ?";
        function __construct(string $idUsuario){
            $this->idUsuario = $idUsuario;
        }

        private function consultarBanco() :array{            
            try{
                $resultado = [];
                $query = CB::getConexao()->prepare($this->query);
        		if(!$query->execute([$this->idUsuario])) throw new \Exception("execução da query falhou");
		        $resultadoConsulta = $query->fetchAll();
        		$resultado = $resultadoConsulta === [] ? ["sem enderecos cadastrados"] : $resultadoConsulta;
            }
            catch(\PDOException|\Exception $ex){
                $GLOBALS['ERRO']->setErro("consulta de endereco", $ex->getMessage());
                $resultado = [];
            }              
            finally{
                return $resultado;
            }
        }
        function getResposta(){
            if(empty($this->resultadoConsulta)) $this->resultadoConsulta = $this->consultarBanco();
            return $this->resultadoConsulta;
        }
    }
 
