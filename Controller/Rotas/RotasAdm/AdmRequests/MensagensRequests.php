<?php
    namespace Controladores\Rotas\RotasAdm\AdmRequests;

    use App\Mensagem\Consultar\{
        TodosUsuarios as TdsMsgs,
        UsuarioEspecifico as MsgnsDele
    };

    class MensagensRequests{
        function todas($data){
            $msgs = new TdsMsgs;
            echo json_encode($msgs->getResposta());
        }
        function usuarioEspecifico($data){
            $msgs = new MsgnsDele($data['idUser']);
            foreach($msgs->getResposta() as $msg){
                echo "<hr>";
                print_r($msg);
            }
        }
    }
