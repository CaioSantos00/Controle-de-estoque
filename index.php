<?php
	require __DIR__."/vendor/autoload.php";

	use CoffeeCode\Router\Router as GerenciadorDeRotas;
	$router = new GerenciadorDeRotas(URL_SITE);
	
	$router->namespace("Controladores\Rotas\RotasUser");
	$router->group(null);
	$router->get("/", "RotasUser:home");
	$router->get("/login", "RotasUser:login");
	$router->get("/cadastro", "RotasUser:cadastro");
	$router->get('/sobre', "RotasUser:sobre");	
	$router->get('/estilo', "RotasUser:estilos");	
	$router->get('/img/{qual}', "RotasUser:img");			
	$router->get('/script/{contexto}/{nome}', "RotasUser:script");
	$router->get('/script/modulos/{contexto}/{scriptPrincipal}/{nomesDosModulosSeparadosPorVirgula}', "RotasUser:scriptModularizado");
	$router->get('/dosErro', 'RotasUser:logErros');	
		
	$router->namespace("Controladores\Rotas\RotasUser\UserRequests");		
	$router->group("usuario");	
	$router->post("/login", "UserRequests:login");
	$router->post("/cadastro", "UserRequests:cadastro");
	
	$router->namespace("Controladores\Rotas\RotasAdm");
	$router->group("admin");
	$router->get("/", "RotasAdm:inicio");
	
	$router->namespace("Controladores\Rotas\RotasAdm\AdmRequests");
	$router->group("admin/envio");
	$router->post("/cadastroProduto", "AdmRequests:cadastrarProduto");
	
	$router->group("ops");
	$router->get("/{erro}", function($data){		
		echo "erro foi só o ".$data['erro'];
	});
	
	$router->dispatch();
	if($router->error()){
		$router->redirect("/ops/{$router->error()}");
	}	