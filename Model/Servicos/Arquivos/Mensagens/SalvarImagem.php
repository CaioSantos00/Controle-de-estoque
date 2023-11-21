<?php
    namespace App\Servicos\Arquivos\Mensagens;

    use App\Interfaces\ServicoInterno;

    class SalvarImagem implements ServicoInterno{
        private string $idMensagem;
        private string $diretorioMensagem = "arqvsSecundarios/Mensagens/";
        function __construct(string $idUsuario, string $idMensagem){
            $this->idMensagem = $idMensagem;
            $this->diretorioMensagem .= $this->idMensagem;
        }
        function executar() {
          $resultado = true;
          $qtdImgs = count($_FILES['imgs']['tmp_name']);
          if(!is_dir($this->diretorioMensagem)) mkdir($this->diretorioMensagem);
          for($x = 0;$x != $qtdImgs; $x++){
            if(!move_uploaded_file(
                $_FILES['imgs']['tmp_name'][$x],
                $this->diretorioMensagem.DIRECTORY_SEPARATOR.$_FILES['imgs']['name'][$x]
            )) $resultado = false;
          }
          return $resultado;
        }
    }
