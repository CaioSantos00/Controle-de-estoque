<?php
	namespace ServerInfo;
	
	use App\Servicos\ErrorLogging\ErrorLogging as ErroHand;
	
	date_default_timezone_set('America/Sao_Paulo'); //Localização atual da empresa	
	
	$GLOBALS['ERRO'] = new ErroHand(); //Define globalmente uma instancia da classe manipuladora de erros
	
	define('URL_SITE', 'http://localhost/Sites/Repositorios/Sistema-de-pedidos-TCC/');		
	
	define('DADOS_CONEXAO_BANCO',
		json_encode(
			[
				'mysql:host=localhost;dbname=mmsx;', //Base
				'root', //Usuário de conexão
				'', //Senha
				array(\PDO::ATTR_PERSISTENT => TRUE) //Outras configurações
			]
		)
	);
	

