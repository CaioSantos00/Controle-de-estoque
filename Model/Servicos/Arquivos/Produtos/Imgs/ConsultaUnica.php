<?php
    namespace App\Servicos\Arquivos\Produtos\Imgs;
    
    use App\Interfaces\ServicoInterno;
    
    class ConsultaUnica implements ServicoInterno{
        protected function getImagens(string $idProduto){
            return array_diff(
                scandir("arqvsSecundarios/Produtos/{$idProduto}"),
                ['.','..']
            );
        }
        function executar(string $idProduto){
            return $this->getImagens($idProduto);
        }
    }
    