<?php
    namespace Controladores\Rotas\RotasUser\UserRequests;

    use App\Mensagem\EnviarMensagem as EMsg;
    class MensagensRequests{
        function __construct(){
            if(!isset($_COOKIE['login'])) exit("manda o usuario se logar primeiro");
        }
        function enviarMensagem($data){
            $contemFotos = count($_FILES['arqvs']['name']) > 0;
            $msg = new EMsg(hex2bin($_COOKIE['login']),$_POST['conteudo'],$contemFotos);
            echo $msg->getResposta();
        }
    }
