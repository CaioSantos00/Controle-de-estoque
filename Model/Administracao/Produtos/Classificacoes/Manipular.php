<?php
    namespace App\Administracao\Produtos\Classificacoes;

    use App\Servicos\Conexao\ConexaoBanco as CB;

    class Manipular{
        private string $idProduto;
        private string $query = "update `produtoprimario` set `classificacoes` = :classificacoes where `Id` = :id";
        function __consntruct(string $idProduto){
            $this->idProduto = $idProduto;
        }
        protected function settarPara(array $classificacoes) :bool{
            try{
                $result = true;
                $query = CB::getConexao()->prepare($this->query);
                $query->execute([
                    'classificacoes' => json_encode($classificacoes),
                    'id' => $this->idProduto
                ]);
                if($query->rowCount() != 1)
                    $result = false;
            }catch(\Exception $e){
                $GLOBALS['ERRO']->setErro("Manipular classificacoes", $e->getMessage());
                $result = false;
            }
            finally{
                return $result;
            }
        }
    }
