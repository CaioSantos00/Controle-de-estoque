<?php
	require __DIR__."/vendor/autoload.php";

	use CoffeeCode\Router\Router as GerenciadorDeRotas;
	$router = new GerenciadorDeRotas(URL_SITE);

	require_once "Controller/URL/Usuario.php";
	require_once "Controller/URL/Admin.php";
	
	$router->group("ops");
	$router->get("/{erro}", function($data){
		echo "erro ".$data['erro'];
	});
	$router->dispatch();
	if($router->error()){
		$router->redirect("/ops/{$router->error()}");
	}
