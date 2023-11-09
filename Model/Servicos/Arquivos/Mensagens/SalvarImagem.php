<?php
    namespace App\Servicos\Arquivos\Mensagens;

    use App\Servicos\Arquivos\UploadsManager;
    use App\Interfaces\ServicoInterno;

    class SalvarImagem implements ServicoInterno{
        private string $idUsuario;
        private string $idMensagem;
        private string $ds =& DIRECTORY_SEPARATOR;
        private string $diretorioMensagem = "arqvsSecundarios/Mensagens/{$this->idMensagem}";
        function __construct(string $idUsuario, string $idMensagem){
            $this->idMensagem = $idMensagem;
            $this->idUsuario = $idUsuario;
        }
        function executar() {
          $resultado = true;
          $qtdImgs = count($_FILES['imgs']['tmp_name']);

          if(!is_dir($this->diretorioMensagem)) mkdir($this->diretorioMensagem);
          for($x = 0;$x != $qtdImgs; $x++){
            if(!move_uploaded_file(
                $_FILES['imgs']['tmp_name'][$x],
                $this->diretorioMensagem.$this->ds.$_FILES['imgs']['name'][$x]
            )) $resultado = false;
          }
          return $resultado;
        }
    }
