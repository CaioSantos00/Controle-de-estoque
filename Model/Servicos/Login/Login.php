<?php
    namespace App\Servicos\Login;

    use App\Servicos\Conexao\ConexaoBanco as Conexao;

    class Login{
        private array $dadosLogin;
        private string $query;
        function __construct(string $email, string $senha){
            $this->dadosLogin = array(
                ":Email" => $email,
                ":Senha" => $senha
            );
            $this->query = "
                Select
                `Id`, `TipoConta`, `Nome`
                from `Usuarios`
                where
                `Email` = :Email and `Senha` = :Senha
            ";
        }

        private function consultarBanco(string $query) :array{
            $select = Conexao::getConexao()
                ->prepare($query)
                ->execute($this->dadosLogin);
            return $select;
        }
        private function setLoginCookie(){
            setcookie('login', bin2hex($this->dadosLogin['Id']), time()+60*60*24*30,'/','localhost');
            if(isset($_COOKIE['login'])){
                return true;
            }
            return false;
        }        
        private function verifyLogin() :bool{
            $this->dadosLogin = $this->consultarBanco($this->query);
            $quantidade = count($this->dadosLogin);            
            switch(true){
                case $quantidade == 1;
                    $retorno = $this->setLoginCookie();
                    break;
                case $quantidade > 1;
                    $GLOBALS['ERRO']->setErro('Login de usuário', 'Usuarios duplicados, verifique imediatamente');
                    $retorno = false; 
                    break;
                case $quantidade == 0;
                    $retorno = false;
                    break;
                default;
                    $GLOBALS['ERRO']->setErro('Login de usuário', 'Erro não identificado');
                    $retorno = false;
            }
            return $retorno;
        }                
    }