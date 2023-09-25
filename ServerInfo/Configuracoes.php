<?php
	namespace Configuracoes;
	
	use App\Servicos\Logging\ErrorLogging as Erro;
	
	date_default_timezone_set('America/Sao_Paulo');
	define('ERRO', new Erro()); //Define globalmente uma instancia da classe manipuladora de erros

