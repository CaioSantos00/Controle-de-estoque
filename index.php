<?php
	require __DIR__."/vendor/autoload.php";

	use CoffeeCode\Router\Router as GerenciadorDeRotas;
	$router = new GerenciadorDeRotas(URL_SITE);
	
	$router->namespace('Configuracoes\Rotas');
	$router->group(null);
	
	$router->get("/", "Rotas::home");
	
	$router->group("ops");
	$router->get("/{erro}", function($data){
		echo "erro foi só o ".$data['erro'];
	});
	$router->dispatch();	
	if($router->error()){
		$router->redirect("/ops/{$router->error()}");
	}