<?php
	$router->namespace("Controladores\Rotas\RotasAdm");
	$router->group("admin");
	$router->get("/", "RotasAdm:inicio");  
	$router->get("/cadastro", "RotasAdm:cadastroProduto");
	$router->get("/consulta", "RotasAdm:consultaProduto");
	$router->get("/erros", "RotasAdm:consultaErros");
	$router->get("/admin", function(){
		header("location: /Sistema-de-pedidos-TCC/admin");
	});

	$router->get('/estilo', "RotasAdm:estilos");
	$router->get('/componentes/{nome}',"RotasAdm:elementos");
	$router->get('/imgs/{qual}', "RotasAdm:img");
	$router->get('/scripts/{contexto}/{nome}', "RotasAdm:script");
	$router->get('/scripts/modulos/{contexto}/{scriptPrincipal}/{nomesDosModulosSeparadosPorVirgula}', "RotasAdm:scriptModularizado");

	$router->namespace("Controladores\Rotas\RotasAdm\AdmRequests");
	$router->group("envio");
	$router->post("/cadastrarProduto", "AdmRequests:cadastrarProduto");
	$router->post("/cadastrarClassificacao", "ClassificacoesRequests:cadastrar");
	$router->post("/editarClassificacao", "ClassificacoesRequests:edicao");
	$router->post("/excluirClassificacao", "ClassificacoesRequests:excluir");
	$router->get("/consultarClassificacoes", "ClassificacoesRequests:consultar");
	$router->get("/atualizarClassificacoes", "ClassificacoesRequests:atualizarArqv");
