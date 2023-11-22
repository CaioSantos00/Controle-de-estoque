<?php
    namespace App\Produto\Variacoes;

    use App\Interfaces\Model;
    use App\Exceptions\UserException;

    class Excluir implements Model{
        private string $idVariacao;
        private string $idProduto;
        private string $query = "delete from `produtosecundario` where `Id` = ?";
        private string $dir = "arqvsSecundarios/Produtos/Fotos/";
        function __construct(string $idVariacao, string $idProduto){
            $this->idVariacao = $idVariacao;
            $this->idProduto= $idProduto;
            $this->dir .= $this->idProduto."/Secundarias/".$this->idVariacao
        }
        private function excluirDadosNoBanco() :bool{
            $query = CB::getConexao()->prepare($this->query);
            $query->execute([$this->idVariacao]);
            return $query->rouCount() == 1
                ? true
                : false;
        }
        private function mapeiaImagens() :array{
            if(!is_dir($this->dir)) throw new UserException("diretório não encontrado");
                $fotos = array_diff(scandir($this->dir),[".",".."]);
            if(count($fotos) == 0)  throw new UserException("sem fotos no diretório");
            return $fotos;
        }
        private function excluirImagens(array $fotos) :array{
            $errados = [];
            foreach($fotos as $foto) if(!unlink($this->dir)) $errados[] = $foto;
            return count($errados) > 0
                ? [false, $errados]
                : [true];
        }
        function getResposta(){
            try{
                $resultado = ["status" => "ok"];
                CB::getConexao()->beginTransaction();
                    $imagens = $this->excluirImagens($this->mapeiaImagens());
                    if(!$imagens[0]) throw new UserException(json_encode($imagens[1]));
                    if(!$this->excluirDadosNoBanco()) throw new \Exception("erro mt interno");
                CB::getConexao()->commit();
            }
            catch(UserException $e){
                CB::voltaTudo();
                $resultado["status"] = "erro ao excluir imagens";
                $resultado["imagens erradas"] = $e->getMessage();
            }
            catch(\Exception|\PDOException $e){
                CB::voltaTudo();
                $resultado["status"] = "erro interno";
                $GLOBALS['ERRO']->setErro("Excluir Variação", $e->getMessage());
            }
            finally{
                return $resultado;
            }
        }
    }
