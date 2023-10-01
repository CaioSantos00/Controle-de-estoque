<?php
	require __DIR__."/vendor/autoload.php";

	use CoffeeCode\Router\Router as GerenciadorDeRotas;
	$router = new GerenciadorDeRotas(URL_SITE);

	$router->namespace("Controladores\Rotas\RotasUser");
	$router->group(null);

	$router->get("/", "RotasUser:home");
	$router->get("/login", "RotasUser:login");
	$router->get("/cadastro", "RotasUser:cadastro");

	$router->namespace("Controladores\Usuario");
	$router->group("usuario");
	
	$router->post("/login", "RotasEnvioDados:login");
	$router->post("/cadastro", "RotasEnvioDados:cadastro");

	$router->group("ops");
	$router->get("/{erro}", function($data){
		echo "erro foi só o ".$data['erro'];
	});
	
	$router->dispatch();
	if($router->error()){
		$router->redirect("/ops/{$router->error()}");
	}