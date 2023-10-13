<?php
	require __DIR__."/vendor/autoload.php";
	
	use Controladores\Rotas\RotasAdm\AdmRequests\AdmRequests as Requests;
	
	$requests = new Requests();
	$requests->excluirProduto(['id'=> 1]);