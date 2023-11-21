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
	$router->get('/visualizarProduto', "RotasUser:visualizarProduto");
	$router->get('/sobre', "RotasUser:sobre");
	$router->get('/Mensagens', "RotasUser:telaMsgs");
	$router->get('/Error', "RotasUser:Error");
	$router->get('/Carrinho', "RotasUser:Carrinho");
	$router->get('/EditarEndereco', "RotasUser:EditarEndereco");
	$router->get('/FinalCarrinho', "RotasUser:FinalCarrinho");
	
	$router->namespace("Controladores\Rotas");
	$router->group("estaticos");
	$router->get('/estilo', "RotasEstaticas:estilos");
	$router->get('/componentes/{nome}',"RotasEstaticas:elementos");
	$router->get('/imgs/{qual}', "RotasEstaticas:img");
	$router->get('/js/{contexto}/{nome}', "RotasEstaticas:script");
	$router->get(
		'/js/subdir/{contexto}/{nomeSubDir}/{nomesArquivosSeparadosPorVirgula}',
		 "RotasEstaticas:subdir"
	);
	$router->get(
		'/js/modulos/{contexto}/{scriptPrincipal}/{nomesDosModulosSeparadosPorVirgula}',
		"RotasEstaticas:scriptModularizado"
	);

	$router->namespace("Controladores\Rotas\RotasUser\UserRequests");
	$router->group("usuario");
	$router->post("/login", "UserRequests:login");
	$router->post("/cadastro", "UserRequests:cadastro");
	$router->post("/mensagem", "UserRequests:mensagem");
/*--------------------------------------------------------------------------------------------------------------------------------------------*/

	$router->namespace("Controladores\Rotas\RotasAdm");
	$router->group("admin");
	$router->get("/", "RotasAdm:inicio");  
	$router->get("/cadastro", "RotasAdm:cadastroProduto");
	$router->get("/consulta", "RotasAdm:consultaProduto");
	$router->get("/erros", "RotasAdm:consultaErros");
	$router->get("/admin", function(){
		header("location: /Sistema-de-pedidos-TCC/admin");
	});

	$router->namespace("Controladores\Rotas\RotasAdm\AdmRequests");
	$router->group("envio");
	$router->post("/cadastrarProduto", "AdmRequests:cadastrarProduto");
	$router->post("/cadastrarClassificacao", "ClassificacoesRequests:cadastrar");
	$router->post("/editarClassificacao", "ClassificacoesRequests:edicao");
	$router->post("/excluirClassificacao", "ClassificacoesRequests:excluir");
	$router->get("/consultarClassificacoes", "ClassificacoesRequests:consultar");
	$router->get("/atualizarClassificacoes", "ClassificacoesRequests:atualizarArqv");

	$router->group("ops");
	$router->get("/{erro}", function($data){
		echo "erro ".$data['erro'];
	});
	$router->dispatch();
	if($router->error()){
		$router->redirect("/ops/{$router->error()}");
	}
