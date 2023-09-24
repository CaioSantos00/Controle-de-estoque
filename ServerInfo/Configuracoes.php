<?php

use App\Servicos\Logging\ErrorLogging;

date_default_timezone_set('America/Sao_Paulo');
define('ERRO', new ErrorLogging()); //Define globalmente uma instancia da classe manipuladora de erros

?>