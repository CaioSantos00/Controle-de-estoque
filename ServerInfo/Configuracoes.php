<?php
	namespace ServerInfo;

	use App\Servicos\ErrorLogging as ErroHand;

	date_default_timezone_set('America/Sao_Paulo'); //Localização atual da empresa

	$GLOBALS['ERRO'] = new ErroHand(); //Define globalmente uma instancia da classe manipuladora de erros

	define('URL_SITE', 'http://localhost/pigs/gitHub/Mmsx/Sistema-de-pedidos-TCC');

	define('DADOS_CONEXAO_BANCO',
		json_encode(
			[
				'mysql:host=localhost;dbname=mmsx;', //Base
				'root', //Usuário de conexão
				'', //Senha
				array(
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
				) //Outras configurações
			]
		)
	);


