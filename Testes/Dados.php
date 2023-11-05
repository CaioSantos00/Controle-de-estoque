<?php
    namespace Testes;

    class Dados{        
        public static string $idUsuario = "36";
        private \stdClass $dado;
        function __construct(){
            $this->dado = new \stdClass;
            $this->dado->idUsuario = self::$idUsuario;
        }
        function endereco(){
            //dados usados na exclusao de enderecos;
            $this->dado->certo = "41";
            $this->dado->errado = "0";
            $this->dado->muitosCertos = ["42","43","46"];
            $this->dado->muitosErrados = ["0","1","2","3","4","5","6","7"];
            $this->dado->misturados = ["0","1","44","3","45"];
            $this->dado->erradosDosMisturados = ["0","1","3"];
        return $this->dado;
        }
        function edicaoEndereco(){
            $this->dado->IdCerto = "50";
            $this->dado->dadosCertos = [
                "nome" => "nome editado",
                "cep" => "11750-000",
                "cidade" => "rua dos editados",
                "rua" => "numero zero",
                "bairro" => "vila losty",
                "numero" => "1190",
                "dadosEntrega" =>  "entrega naode tem edição",
            ];
            return $this->dado;
        }
    }
