<?php
  namespace App\Mensagem\Consultar;

  use App\Servicos\Conexao\ConexaoBanco as CB;
  use App\Usuario\Perfil as User;
  use App\Exceptions\UserException;
  use App\Interfaces\Model;

  class TodosUsuarios implements Model{
    private string $erro;
    private string $query = "select `Id`, `parentId`,`conteudo`,`DataEnvio` from `mensagens`";
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
    private function getInfoUsuario(string $idUsuario) :array{
        return (new User($idUsuario, false))->getResposta();
    }
    private function combinarInformacoes(array $resultadoConsulta) :array{
        $linhas = [];
        foreach ($resultadoConsulta as $linha){
            $linhas[] = [
                "Id" => $linha['Id'],
                "parentId" => $linha['parentId'],
                "conteudo" => $linha['conteudo'],
                "DataEnvio" => $linha['DataEnvio']
            ];
        }
        $usuarios = array_unique(array_column($linhas,'parentId'));
        foreach($usuarios as $chav => $usuario)
            $usuarios[$usuario] = $this->getInfoUsuario($usuario);

        return [
            "mensagens" => $linhas,
            "usuarios" => $usuarios
        ];
    }
    function getResposta(){
        $msgs = $this->buscarMsgsNoBanco();
        return $msgs
            ? $this->combinarInformacoes($msgs)
            : $this->erro;
    }
  }
