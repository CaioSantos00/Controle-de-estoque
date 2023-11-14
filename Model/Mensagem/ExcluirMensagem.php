<?php
    namespace App\Mensagem;

    use App\Servicos\Conexao\ConexaoBanco as CB;
    use App\Interfaces\Model;

    class ExcluirMensagem implements Model{
      public string $idMensagem;
      private string $idUsuario;
      private string $query;
      function __construct(string $idUsuario, string $idMensagem){
        $this->idUsuario = $idUsuario;
        $this->idMensagem = $idMensagem;
      }
      private function apagarArqvs(){

      }
      private function excluirNoBanco(){

      }
      function getResposta(){

      }
    }
