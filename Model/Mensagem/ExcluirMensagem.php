<?php
    namespace App\Mensagem;

    use App\Servicos\Conexao\ConexaoBanco as CB;
    use App\Exceptions\UserException;
    use App\Interfaces\Model;

    class ExcluirMensagem implements Model{
        public string $idMensagem;
        private string $idUsuario;
        private string $diretorioImagens = "arqvsSecundarios/fotosMensagens/";
        public string $erro = "";
        private string $query = "delete from `mensagens` where `Id` = ? and `parentId` = ?";
        function __construct(string $idUsuario, string $idMensagem){
          $this->idUsuario = $idUsuario;
          $this->idMensagem = $idMensagem;
          $this->diretorioImagens .= $idMensagem;
        }
        private function verificaDiretorio(string $dir) :array{            
            if(!is_dir($dir))
                throw new UserException("diretório não encontrado");
            $fotos = array_diff(
                ['.','..'],
                scandir($dir)
            );
            if(count($fotos) == 0)
                throw new UserException("não contém fotos");
            return $fotos;
        }
        private function apagarArqvs() :bool{
            try{
                $retorno = true;                
                $resultados = [];
                $fotos = $this->verificaDiretorio($this->diretorioImagens);
                foreach($fotos as $foto)
                    $resultados[$foto] = unlink("{$this->diretorioImagens}/{$foto}");
                $errados = array_filter($resultados,function($v){
                    return !$v;
                });
                if(count($errados) != 0) throw new UserException(json_encode(array_keys($errados)));
            }
            catch(UserException $e){
                $this->erro .= " ".$e->getMessage();
                $retorno = false;
            }
            finally{
                return $retorno;
            }
        }
        private function excluirNoBanco(\PDO $conn) :bool{
            try{
                $retorno = true;
                $query = $conn->prepare($this->query);
                $query->execute([$this->idMensagem, $this->idUsuario]);
                if($query->rowCount() == 0)
                    throw new UserException("Mensagem não excluida");
            }
            catch(UserException $e){
                $retorno = false;
                $this->erro .= $e->getMessage()." mas excluiu do banco";
            }
            catch(\PDOException $ex){
                $retorno = false;
                $GLOBALS['ERRO']->setErro("Excluir mensagem", $ex->getMessage());
                $this->erro .= "erro interno";
            }
            finally{
                return $retorno;
            }    
        }
        function getResposta(){            
            if($this->excluirNoBanco(CB::getConexao()))
                return $this->apagarArqvs();
            return false;
        }
    }
