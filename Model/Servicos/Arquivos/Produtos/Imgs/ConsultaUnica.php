<?php
    namespace App\Servicos\Arquivos\Produtos\Imgs;
    
    use App\Interfaces\ServicoInterno;
    
    class ConsultaUnica implements ServicoInterno{
        private string $idProduto;
        protected function getImagens(string $idProduto){
            $this->idProduto = $idProduto;
            return array(
                "Principais" => $this->getTodasFotosDeUmDiretorio("Principais"),
                "Secundarios" => $this->getTodasFotosDeUmDiretorio("Secundarias")
            );
        }
        protected function getTodasFotosDeUmDiretorio(string $caminho){
            return array_diff(scandir("arqvsSecundarios/Produtos/{$this->idProduto}/{$caminho}"),['.','..']);            
        }
        function executar(string $idProduto){
            return $this->getImagens($idProduto);
        }
    }