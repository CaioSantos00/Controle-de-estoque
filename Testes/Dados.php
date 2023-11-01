<?php
    namespace Testes;

    class Dados{

        public string $idUsuario = "36";
        private \stdClass $dado;
        function __construct(){
            $this->dado = new \stdClass;
            $this->dado->idUsuario = $this->idUsuario;       
        }
        function endereco(){
            $this->dado->certo = "32";
            $this->dado->errado = "0";
            $this->dado->muitosCertos = [];
            $this->dado->muitosErrados = ["0","1","2","3","4","5","6","7"];
            $this->dado->misturados = ["0","1","32","3","4"];
            return $this->dado; 
        }
    }
