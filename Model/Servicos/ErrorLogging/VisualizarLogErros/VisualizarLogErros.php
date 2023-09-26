<?php
    namespace App\Servicos\ErrorLogging\VisualizarLogErros;

	use App\Servicos\ErrorLogging\ErrorLogging\ErrorLogging as LogDeErros;

    class VisualizarLogErros{
        public array $erros;

        function __construct(){
            $this->erros = $this->getErros();
        }
        function __toString(){
            return json_encode($this->erros);
        }
        private function getErros() :array{
            $logErros = file_get_contents(LogDeErros::LOG_LOCATION); //Recebe os conteúdos crus do arquivo do log de Erros;

            if($logErros === false){
                $GLOBALS['ERRO']->setErro('Visualização de erros', 'Não deu para abrir o log de erros');
                return ['agora','No Log de erros', 'não deu para abrir o log de erros'];
            }

            return explode(LogDeErros::SEPARADOR_DE_ERROS,$logErros);
        }
    }