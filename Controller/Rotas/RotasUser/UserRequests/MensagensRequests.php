<?php
    namespace Controladores\Rotas\RotasUser\UserRequests;

    class MensagensRequests{
        private bool $logado;
        function __construct(){
            if(isset($_COOKIE['login'])) $this->logado = true;
        }
        function enviarMensagem($data){

        }
    }
