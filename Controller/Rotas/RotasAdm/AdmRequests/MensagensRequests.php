<?php
    namespace Controladores\Rotas\RotasAdm\AdmRequests;

    use App\Mensagem\Consultar\{
        TodosUsuarios as TdsMsgs,
        UsuarioEspecifico as MsgnsDele
    };
    use App\Mensagem\VisualizarMensagem;
    
    use App\Servicos\Arquivos\Mensagens\BuscarImagens as BIMsg;
    class MensagensRequests{
        function todas($data){
            $msgs = new TdsMsgs;
            echo json_encode($msgs->getResposta());
        }
        function usuarioEspecifico($data){
            $msgs = (new MsgnsDele($data['idUser'], new BIMsg))->getResposta();
            echo match(true){
                is_string($msgs) => $msgs,
                is_array($msgs) => json_encode($msgs, JSON_PRETTY_PRINT),
                default => "erro interno"                
            };
        }
        function visualizarMsg($data){
            echo (new VisualizarMensagem($data['idMsg']))->getResposta();
        }
    }
