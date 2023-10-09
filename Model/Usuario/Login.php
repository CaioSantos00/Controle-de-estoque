<?php
    namespace App\Usuario;

    use App\Servicos\Conexao\ConexaoBanco as Conexao;
    use App\Interfaces\Model;
    
    class Login implements Model{
        private array $dadosLogin;
        private string $query;
        private string $resposta;
        
        function __construct(string $email, string $senha){
            $this->dadosLogin = [$email,$senha];
            $this->query = "
                Select
                `Id`, `TipoConta`, `Nome`
                from `usuario`
                where
                `Email` = ? and `Senha` = ?
            ";
        }

        private function consultarBanco(string $query) :array{
            try{
                $select = Conexao::getConexao()->prepare($query);
                
                if(!$select->execute($this->dadosLogin)) throw new \Exception(", falhow na execução");
                $select = $select->fetchAll();
            }
            catch(\PDOException $ex){
                $GLOBALS['ERRO']->setErro('Login de usuário', 'Falha no PDO, '.$ex->getMessage());
                $this->resposta = "Sem Login, Erro interno";
                $select = [];
            }
            catch(\Exception $e){
                $GLOBALS['ERRO']->setErro('Login de usuário', 'Falha na Conexão PDO'.$e->getMessage());
                $this->resposta = "Sem Login, Erro interno";
                $select = [];
            }
            finally{                
                return $select;
            }            
        }
        private function setLoginCookie() :string{                        
            if(setcookie('login', bin2hex($this->dadosLogin[0]['Id']), time()+60*60*24*30,'/','localhost')){
                if($this->dadosLogin[0]['TipoConta'] != "0") setcookie('TipoConta', bin2hex($this->dadosLogin[0]['TipoConta']), time()+60*60*24*30,'/','localhost');
                return "logou certinho";
            }
            return "Usuario logado, mas sem cookie settado, gerir no JS";            
        }        
        private function verifyLogin() :string{
            $this->dadosLogin = $this->consultarBanco($this->query);            
            $quantidade = count($this->dadosLogin);            
            if($quantidade == 1){
                return $this->setLoginCookie();
            }            
            switch(true){                
                case $quantidade > 1;
                    $GLOBALS['ERRO']->setErro('Login de usuário', 'Usuarios duplicados, verifique imediatamente');
                    $retorno = "usuario duplicado"; 
                    break;
                case $quantidade == 0 or $this->dadosLogin == [];
                    $retorno = "usuario não encontrado";
                    break;
                default;
                    $GLOBALS['ERRO']->setErro('Login de usuário', 'Erro não identificado');
                    $retorno = "algo de errado aconteceu";
            }
            return $retorno;
        }
        function getResposta() :string{
            return $this->verifyLogin();
        }
    }