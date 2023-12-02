<?php
  namespace App\Mensagem\Consultar;

  use App\Servicos\Conexao\ConexaoBanco as CB;
  use App\Usuario\Perfil as User;
  use App\Exceptions\UserException;
  use App\Interfaces\Model;

  class TodosUsuarios implements Model{
    private string $erro;
    private string $query = "SELECT
    mensagens.Id, mensagens.Status, mensagens.DataEnvio, mensagens.conteudo, usuario.Nome
    from `mensagens`
    inner JOIN `usuario`
    on mensagens.parentId = usuario.Id";
    private function buscarMsgsNoBanco() :bool|array{
      try{
        $query = CB::getConexao()->query($this->query);
        if(is_bool($query)) throw new UserException("erro interno");
        $query = $query->fetchAll();
      }
      catch(UserException $e){
        $this->erro = $e->getMessage();
        $query = false;
      }
      catch(\PDOException|\Exception $e){
        $GLOBALS['ERRO']->setErro("Consulta de mensagens", $e->getMessage());
        $this->erro = "erro interno";
        $query = false;
      }
      finally{
        return $query;
      }
    }
    private function combinarInformacoes(array $resultadoConsulta) :array{
        $linhas = [];
        foreach ($resultadoConsulta as $linha)
            $linhas[] = [
                "Id" => $linha['Id'],                
                "conteudo" => $linha['conteudo'],
                "DataEnvio" => $linha['DataEnvio'],
                "NomeUsuario" => $linha['Nome'],
                "Status" => $linha['Status']
            ];
        return $linhas;
    }
    function getResposta(){
        $msgs = $this->buscarMsgsNoBanco();
        return $msgs
            ? $this->combinarInformacoes($msgs)
            : $this->erro;
    }
  }
