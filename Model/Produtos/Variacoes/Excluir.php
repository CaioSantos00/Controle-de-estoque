<?php
    namespace App\Produtos\Variacoes;

    use App\Servicos\Conexao\ConexaoBanco as CB;
    use App\Interfaces\Model;

    class Excluir implements Model{
        private string $idVariacao;
        private string $idProduto;
        function __construct(string $idVariacao, string $idProduto){
            $this->idProduto = $idProduto;
            $this->idVariacao = $idVariacao;
        }
        function getResposta(){
            
        }
    }
