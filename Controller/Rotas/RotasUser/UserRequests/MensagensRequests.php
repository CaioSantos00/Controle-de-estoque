<?php
    namespace Controladores\Rotas\RotasUser\UserRequests;

    use App\Mensagem\EnviarMensagem as EMsg;
    use App\Mensagem\Consultar\UsuarioEspecifico as CMUEscfo;
    class MensagensRequests{
        function __construct(){
            if(!isset($_COOKIE['login'])) exit("manda o usuario se logar primeiro");
        }
        function enviarMensagem($data){           
            if(
                !isset($_POST['Conteudo']) or
                !isset($_FILES['imgs']) or
                !isset($_POST['Motivo'])
            ) exit("nem deu");
            $conteudo = [
                "conteudo" => $_POST['Conteudo'],
                "motivo" => $_POST['Motivo']
            ];
            $msg = new EMsg(
                hex2bin($_COOKIE['login']),
                json_encode($conteudo),                
                count($_FILES['imgs']['name']) > 0
            );
            echo $msg->getResposta();
        }
        function consultarMensagens($data){
            $consulta = new CMUEscfo(hex2bin($_COOKIE['login']));
            print_r($consulta->getResposta());
        }
    }
