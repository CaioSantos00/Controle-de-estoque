<?php
    namespace App\Mensagem;

    use App\Servicos\Conexao\ConexaoBanco as CB;
    use App\Interfaces\Model;

    class ExcluirMensagem implements Model{
      private string $idUsuario;
      public string $idMensagem;
      function __construct(string $idUsuario){
        $this->idUsuario = $idUsuario;
      }
      private function apagarArqvs(){

      }
      private function excluirNoBanco(){

      }
      function getResposta(){

      }
    }
