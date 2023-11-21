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
        protected function getTodasFotosDeUmDiretorio(string $caminho) :array|bool{
            $dir = "arqvsSecundarios/Produtos/Fotos/{$this->idProduto}/{$caminho}";
            if(!is_dir($dir)) return false;
            return array_diff(scandir($dir),['.','..']);
        }
        function executar(){
            return $this->getImagens($this->idProduto);
        }
    }