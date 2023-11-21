<?php
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
	
	$router->namespace("Controladores\Rotas\RotasUser\UserRequests");
	$router->group("usuario");
	$router->post("/login", "UserRequests:login");
	$router->post("/cadastro", "UserRequests:cadastro");
	$router->post("/mensagem", "UserRequests:mensagem");
