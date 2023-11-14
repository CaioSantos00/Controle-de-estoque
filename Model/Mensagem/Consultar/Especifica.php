<?php
  namespace App\Mensagem\Consultar;

  use App\Servicos\Conexao\ConexaoBanco as CB;
  use App\Interfaces\ServicoInterno;
  use App\Exceptions\Showable;

  class Especifica implements ServicoInterno{
    public array $arquivos;
    public array $mensagem;
    public string $erro;
    private string $idMensagem;
    private string $query = "select `parentId`,`conteudo`,`DataEnvio` from `mensagens` where `Id` = ?";
    private string $diretorio;
    function __construct(string $idMensagem){
      $this->idMensagem = $idMensagem;
      $this->diretorio = "arqvsSecundarios/Mensagens/".$this->idMensagem;
    }
    private function getDadosBanco() :array|bool{
      try{
        $resposta = false;
        $query = CB::getConexao()->prepare($this->query);
        $query->execute([$this->idMensagem]);
        $resposta = $query->fetchAll();
      }
      catch(\Exception $e){
        $respota = false;
        CB::voltaTudo();
        $GLOBALS['ERRO']->setErro("Consulta mensagem", $e->getMessage());
      }
      finally{
        return $resposta;
      }
    }
    private function temArquivos() :bool{
      return is_dir($this->diretorio);
    }
    private function getArquivos() :array{
      return array_diff(
        [".",".."],
        scandir($this->diretorio)
      );
    }
    function executar(){
      try{
        if(!$this->temArquivos()) throw new Showable("não tem arquivos");
        $this->arquivos = $this->getArquivos();
        $mensagem = $this->getDadosBanco();
        if(is_bool($mensagem)) throw new Showable("não encontrada");
        $this->mensagem = $mensagem;
      }
      catch(Showable $ex){
        $this->erro = $ex->getMessage();
      }
      catch(\Exception $e){
        $GLOBALS['ERRO']->setErro("Consulta mensagem", $e->getMessage());
      }
    }
  }
