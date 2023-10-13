<?php
    namespace App\Servicos\Arquivos\Produtos\Imgs;
    
    use App\Interfaces\ServicoInterno as SI;
    
    class ConsultaUnica implements SI{
        public string $idProduto;
        protected function getImagens(string $idProduto){
            $this->idProduto = $idProduto;
            return array(
                "Principais" => $this->getTodasFotosDeUmDiretorio("Principais"),
                "Secundarios" => $this->getTodasFotosDeUmDiretorio("Secundarios")
            );
        }
        protected function getTodasFotosDeUmDiretorio(string $caminho){
            return array_diff(scandir("arqvsSecundarios/Produtos/Fotos/{$this->idProduto}/{$caminho}"),['.','..']);            
        }
        function executar(){
            return $this->getImagens($this->idProduto);
        }
    }