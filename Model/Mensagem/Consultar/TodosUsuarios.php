<?php
  namespace App\Mensagem\Consultar;
  
  use App\Servicos\Conexao\ConexaoBanco as CB;
  use App\Exceptions\UserException;
  use App\Interfaces\{
    Model,
    Mostravel
  };
  
  class TodosUsuarios implements Model{
    private string $erro;
    private string $query = "select `Id`, `parentId`,`conteudo`,`DataEnvio` from `mensagens` group by `parentId`";
    private function buscarMsgsNoBanco() :bool|array{
      try{
        $query = CB::getConexao()->query($this->query);        
        if(is_bool($query)) throw new UserException("erro interno");
        $query = $query->fetchAll();
      }      
      catch(Mostravel $e){
        $this->erro = $e->getMessage();
      }
      catch(\PDOException|\Exception $e){
        $GLOBALS['ERRO']->setErro("Consulta de mensagens", $e->getMessage());
        $query = false;
      }
      finally{
        return $query;
      }
    }
    private function getInfoDeCadaUser(){
      
    }
    function getResposta(){
      return $this->buscarMsgsNoBanco();
    }
  }
