<?php
    namespace App\Servicos\Login;

    use App\Servicos\Conexao\ConexaoBanco as Conexao;

    class Login{
        private array $dadosLogin;
        private string $query;
        private string $resposta;
        
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
            try{
                $select = Conexao::getConexao()
                    ->prepare($query)
                    ->execute($this->dadosLogin);
            }
            catch(PDOException $ex){
                $GLOBALS['ERRO']->setErro('Login de usuário', 'Falha no PDO, '.$ex->getMessage());
                $this->resposta = "Sem Login, Erro interno";
                $select = [];
            }
            catch(Exception $e){
                $GLOBALS['ERRO']->setErro('Login de usuário', 'Falha na Conexão PDO'.$e->getMessage());
                $this->resposta = "Sem Login, Erro interno";
                $select = [];
            }
            finally{
                return $select;
            }            
        }
        private function setLoginCookie() :bool{
            $cookieInstanciado = setcookie('login', bin2hex($this->dadosLogin['Id']), time()+60*60*24*30,'/','localhost');
            
            if($cookieInstanciado){
                if(isset($_COOKIE['login'])){
                    return true;
                }
                $this->resposta = "Usuario logado, mas não aceitou os cookies";
                return false;
            }
            $this->resposta = "Usuario logado, mas sem cookie settado, gerir no JS";            
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
                case $quantidade == 0 or $this->dadosLogin == [];
                    $retorno = false;
                    break;
                default;
                    $GLOBALS['ERRO']->setErro('Login de usuário', 'Erro não identificado');
                    $retorno = false;
            }
            return $retorno;
        }
        function getResposta() :string{
            if($this->verifyLogin()) return "{$this->resposta}";
            return "Sem login";
        }
    }