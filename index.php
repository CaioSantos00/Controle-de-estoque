<?php
	require __DIR__."/vendor/autoload.php";

	use CoffeeCode\Router\Router as GerenciadorDeRotas;
	$router = new GerenciadorDeRotas(URL_SITE);

	$router->namespace("Controladores\Rotas\RotasUser");
	$router->group(null);
	$router->get("/", "RotasUser:home");
	$router->get("/home", "RotasUser:home");
	$router->get("/login", "RotasUser:login");
	$router->get("/cadastro", "RotasUser:cadastro");
	$router->get('/sobre', "RotasUser:sobre");		
	$router->get('/produtos', "RotasUser:produtos");
	$router->get('/sobre', "RotasUser:sobre");
	$router->get('/telaMensagens', "RotasUser:telaMsgs");
	
	$router->get('/estilo', "RotasUser:estilos");
	$router->get('/componentes/{nome}',"RotasUser:elementos");
	$router->get('/imgs/{qual}', "RotasUser:img");			
	$router->get('/scripts/{contexto}/{nome}', "RotasUser:script");
	$router->get('/scripts/modulos/{contexto}/{scriptPrincipal}/{nomesDosModulosSeparadosPorVirgula}', "RotasUser:scriptModularizado");
		
	$router->namespace("Controladores\Rotas\RotasUser\UserRequests");		
	$router->group("usuario");	
	$router->post("/login", "UserRequests:login");
	$router->post("/cadastro", "UserRequests:cadastro");
	$router->post("/mensagem", "UserRequests:mensagem");	
	
	$router->namespace("Controladores\Rotas\RotasAdm");
	$router->group("admin");
	$router->get("/", "RotasAdm:inicio");
	$router->get("/cadastro", "RotasAdm:cadastroProduto");
	$router->get("/consulta", "RotasAdm:consultaProduto");
	$router->get("/erros", "RotasAdm:consultaErros");
	
	$router->get('/estilo', "RotasAdm:estilos");
	$router->get('/componentes/{nome}',"RotasAdm:elementos");
	$router->get('/imgs/{qual}', "RotasAdm:img");			
	$router->get('/scripts/{contexto}/{nome}', "RotasAdm:script");
	$router->get('/scripts/modulos/{contexto}/{scriptPrincipal}/{nomesDosModulosSeparadosPorVirgula}', "RotasAdm:scriptModularizado");
	
	$router->namespace("Controladores\Rotas\RotasAdm\AdmRequests");
	$router->group("envio");	
	$router->post("/cadastrarProduto", "AdmRequests:cadastrarProduto");
	
	$router->group("ops");
	$router->get("/{erro}", function($data){		
		echo "erro ".$data['erro'];
	});
	$router->dispatch();
	if($router->error()){	    
		$router->redirect("/ops/{$router->error()}");
	}	
