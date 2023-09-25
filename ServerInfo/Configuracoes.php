<?php
	namespace Configuracoes;
	
	use App\Servicos\ErrorLogging\LogDeErros as ErroHand;
	
	date_default_timezone_set('America/Sao_Paulo');
	$GLOBALS['ERRO'] = new ErroHand(); //Define globalmente uma instancia da classe manipuladora de erros

