<?php
    namespace Controladores\Rotas\RotasAdm\AdmRequests;

    use App\Mensagem\Consultar\{
        TodosUsuarios as TdsMsgs,
        UsuarioEspecifico as MsgnsDele,
        Especifica as MsgUnica
    };
    use App\Servicos\Arquivos\Mensagens\BuscarImagens as ImgMsg;
    use App\Mensagem\VisualizarMensagem;

    use App\Servicos\Arquivos\Mensagens\BuscarImagens as BIMsg;
    class MensagensRequests{
        function todas($data){
            echo json_encode((new TdsMsgs)->getResposta());
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
            if($data['idMsg'] == "nenhuma" or !is_numeric($data['idMsg'])) exit("sem mensagem é foda");
            echo (new VisualizarMensagem($data['idMsg']))->getResposta();
        }
        function mensagemEspecifica($data){
            if($data['idMsg'] == "nenhuma") exit( "sem mensagem é foda");
            $msg = new MsgUnica($data['idMsg']);
            $imgs = new ImgMsg;
            $imgs->setIdMsg($data['idMsg']);
            $imgs->executar();
            echo $msg->executar()
                ? json_encode([...$msg->mensagem, "imagens" => $imgs->getImagens()])
                : $msg->erro;
        }
    }
