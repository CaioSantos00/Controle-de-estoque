<?php
    namespace App\Utilizador\Usuario;
    
    use App\Utilizador\IUtilizador;
    use App\Servicos\Conexao\ConexaoBanco as Conexao;
    
    class Usuario implements IUtilizador{
        protected string $idUsuario;
        function verificarLogin(string $loginCookie) :bool{
            $this->idUsuario = hex2bin($loginCookie);
        }        
    }