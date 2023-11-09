<?php
  namespace App\Servicos\Arquivos\Mensagens;

  use App\Interfaces\ServicoInterno;

  class ExcluirImagem implements ServicoInterno{
    private string $nomeImagem;
    private string $idMensagem;
    function __construct(string $idMensagem ,string $nomeImagem){
      $this->nomeImagem = $nomeImagem;
      $this->idMensagem = $idMensagem;
    }
    function executar(){
      return unlink("arqvsSecundarios/Mensagens/{$this->idMensagem}/{$this->nomeImagem}");
    }
  }
