<?php
    namespace App\Servicos\Logging;

    use App\Servicos\Logging\LogDeErros;

    class VisualizacaoLogErros{            
        static function getErros() :string{
            $logErros = file_get_contents(LogDeErros::LOG_LOCATION); //Recebe os conteúdos crus do arquivo do log de Erros;
            
            if($logErros === false){
                $GLOBALS['ERRO']->setErro('Visualização de erros', 'não deu para abrir o arquivo');
                return [false];
            }
            
            $logErros = explode(LogDeErros::SEPARADOR_DE_ERROS,$logErros);
                
            foreach($logErros as $indice => $valor){
                $logErros[$indice] = json_decode($valor);
            }
        }
    }