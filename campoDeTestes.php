<?php
	require __DIR__."/vendor/autoload.php";
	
	use Controladores\Rotas\RotasUser\UserRequests\CarrinhoRequests as Requests;
	
	$requests = new Requests();
	$requests->finalizar(
		[
			"login" => bin2hex(36),
			"idVariacao" => 1,
			"qtd" => 10
		]
	);