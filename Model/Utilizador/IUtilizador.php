<?php
    namespace App\Utilizador;
    
    interface IUtilizador{
        function verificarLogin(string $loginCookie) :bool;
    }