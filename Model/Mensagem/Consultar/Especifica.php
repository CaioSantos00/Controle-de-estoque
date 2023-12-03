<?php
  namespace App\Mensagem\Consultar;

  use App\Servicos\Conexao\ConexaoBanco as CB;
  use App\Exceptions\UserException;
  use App\Interfaces\ServicoInterno;
  
  class Especifica implements ServicoInterno{
    public array $mensagem;
    public string $erro;
    private string $idMensagem;
    private string $query = "select `Id`,`parentId`,`conteudo`,`DataEnvio` from `mensagens` where `Id` = ?";
    function __construct(string $idMensagem){
      $this->idMensagem = $idMensagem;
    }
    private function getDadosBanco() :array|bool{
      try{
        $resposta = false;
        $query = CB::getConexao()->prepare($this->query);
        $query->execute([$this->idMensagem]);
        $consulta = $query->fetchAll();
        foreach($consulta as $linha)
          $resposta = [
            "idMsg" => $linha["Id"],
            "parentId" => $linha["parentId"],
            "conteudo" => json_decode($linha["conteudo"], true),
            "DataEnvio" => $linha["DataEnvio"]
          ];
      }
      catch(\PDOException|\Exception $e){
        $resposta = false;
        CB::voltaTudo();
        $GLOBALS['ERRO']->setErro("Consulta mensagem", $e->getMessage());
      }
      finally{
        return $resposta;
      }
    }    
    function executar(){
      try{
        $resposta = true;
        $mensagem = $this->getDadosBanco();
        if(is_bool($mensagem)) throw new \Exception("não encontrada");
        $this->mensagem = $mensagem;
      }      
      catch(\Exception|\PDOException $e){
        $resposta = false;
        $GLOBALS['ERRO']->setErro("Consulta mensagem", $e->getMessage());
        $this->erro = "erro interno";
      }
      finally{
        return $resposta;
      }
    }
  }
