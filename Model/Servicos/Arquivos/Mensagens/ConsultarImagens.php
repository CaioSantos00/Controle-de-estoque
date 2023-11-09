<?php
  namespace App\Servicos\Arquivos\Mensagens;

  use App\Interfaces\ServicoInterno;

  class ConsultarImagens implements ServicoInterno{
    private string $idMensagem;
    public array $imagens = [];
    function __construct(string $idMensagem){
      $this->idMensagem = $idMensagem;
    }
    function executar(){
      $diretorio = "arqvsSecundarios/Mensagens/{$this->idMensagem}";
      if(!is_dir($diretorio)) return false;
      $this->imagens = array_diff(
        ['.','..'],
        scandir($diretorio)
      );
      return true;
    }
  }
