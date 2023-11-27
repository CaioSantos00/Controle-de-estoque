<?php
    namespace App\Administracao\Produtos\Classificacoes;

    use App\Interfaces\Model;
    use App\Administracao\Produtos\Classificacoes\Manipular;

    class Adicionar extends Manipular implements Model{
        private string $classificacao;
        function __construct(string $classificacao, string $idProduto){
            parent::__construct($idProduto);
            $this->classificacao = $classificacao;
        }
        private function
        function getResposta(){

        }
    }
