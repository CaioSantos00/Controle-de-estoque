<?php
    namespace App\Usuario;

    use App\Servicos\Conexao\ConexaoBanco as Conexao;
    use App\Interfaces\Model;

    class Login implements Model{
        private array $dadosLogin;
        private string $query= "
            Select
            `Id`, `TipoConta`, `Nome`,`Senha`
            from `usuario`
            where
            `Email` = ?
        ";
        private string $resposta;
        private bool $testando = false;
        private string $senha;
        private string $email;
        function __construct(string $email, string $senha, bool $testando = false){
            $this->testando = $testando;
            $this->email = $email;
            $this->senha = $senha;
        }

        private function consultarBanco(string $query) :array{
            try{
                $select = Conexao::getConexao()->prepare($query);

                if(!$select->execute([$this->email])) throw new \Exception(", falhow na execução");
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
        private function setLoginCookie(string $id, string $tipoConta) :string{
            if($this->testando)
                return "logou certinho";
            if(setcookie('login', bin2hex($id), time()+60*60*24*30,'/','localhost')){
                if($tipoConta != "0")
                    setcookie('TipoConta', bin2hex($tipoConta), time()+60*60*24*30,'/','localhost');
                return "logou certinho";
            }
            return "Usuario logado, mas sem cookie settado, gerir no JS";
        }
        private function verifyLogin() :string{
            $dados = $this->consultarBanco($this->query);
            foreach ($dados as $value)
                if(password_verify($this->senha, $value['Senha']))
                    return $this->setLoginCookie($value['Id'], $value['TipoConta']);
            return "usuario não encontrado";
        }
        function getResposta() :string{
            return $this->verifyLogin();
        }
    }
