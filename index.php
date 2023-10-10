<?php
	require __DIR__."/vendor/autoload.php";

	use CoffeeCode\Router\Router as GerenciadorDeRotas;
	
	$router = new GerenciadorDeRotas(URL_SITE);	
	$router->namespace("Controladores\Rotas\RotasUser");
	$router->group(null);
	
	$router->get("/", "RotasUser:home");		
	$router->get("/inicio", "RotasUser:home");	
	$router->get("/login", "RotasUser:login");
	$router->get("/cadastro", "RotasUser:cadastro");
	$router->get('/sobre', "RotasUser:sobre");	
	$router->get('/estilo', "RotasUser:estilo");
	$router->get('/produtos', "RotasUser:produtos");
	$router->get('/telaMensagens', "RotasUser:telaMensagens");	
	$router->get('/adm', "RotasUser:adm");
	$router->get('/errosAdm', "RotasUser:errosAdm");
<<<<<<< Updated upstream
	$router->get('/cadastroProduto', "RotasUser:cadastroProduto");
=======
	$router->get('/arquivoError', "RotasUser:arquivoError");
>>>>>>> Stashed changes
	$router->get('/telaError', "RotasUser:telaError");					
	$router->get('/imgs/{qual}', "RotasUser:imgs");		
	$router->get('/scripts/{cont}/{qual}', "RotasUser:scripts");	

	$router->namespace("Controladores\Rotas\RotasUser\UserRequests");		
	$router->group("usuario");
	
	$router->post("/login", "UserRequests:login");
	$router->post("/cadastro", "UserRequests:cadastro");

	$router->namespace("Controladores\Rotas\RotasComponentes");
	$router->group("componentes");		
	$router->get('/header', "RotasComponentes:header");

	
	$router->group("ops");
	$router->get("/{erro}", function($data){
		echo "erro foi só o ".$data['erro'];
	});
	
	$router->dispatch();
	if($router->error()){
		$router->redirect("/ops/{$router->error()}");
	}