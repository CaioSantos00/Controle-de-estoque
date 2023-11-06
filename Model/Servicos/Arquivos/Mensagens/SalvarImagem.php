<?php
    namespace App\Servicos\Arquivos\Mensagens;
       
    use App\Servicos\Arquivos\UploadsManager;
    use App\Interfaces\ServicoInterno;
    
    class SalvarImagem implements ServicoInterno{
        private string $idUsuario;
        private string $idMensagem;
        function __construct(string $idUsuario, string $idMensagem){
            $this->idMensagem = $idMensagem;
            $this->idUsuario = $idUsuario;
        }
        function executar() {
            
        }
    }