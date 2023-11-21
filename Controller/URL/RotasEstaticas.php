<?php
	$router->namespace("Controladores\Rotas");
	$router->group("e");
	$router->get('/estilo', "RotasEstaticas:estilos");
	$router->get('/componentes/{nome}',"RotasEstaticas:elementos");
	$router->get('/imgs/{qual}', "RotasEstaticas:img");
	$router->get('/scripts/{contexto}/{nome}', "RotasEstaticas:script");
	$router->get(
		'/scripts/modulos/{contexto}/{scriptPrincipal}/{nomesDosModulosSeparadosPorVirgula}',
		"RotasEstaticas:scriptModularizado"
	);
