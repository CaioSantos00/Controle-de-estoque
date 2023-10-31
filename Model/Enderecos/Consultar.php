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

        private function consultarBanco() :array|string{            
            try{
                $resultado = [];
                CB::getConexao()->beginTransaction();
                $query = CB::getConexao()->prepare($this->query);
                $query->execute([$this->idUsuario]);
                $resultado = $query->fetchAll();
                CB::getConexao()->commit();
            }
            catch(\PDOException|\Exception $ex){
                $GLOBALS['ERRO']->setErro("consulta de endereco", $ex->getMessage());
                CB::voltaTudo();
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
 
