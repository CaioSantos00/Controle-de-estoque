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
	$router->get('/MinhasMensagens', "RotasUser:MinhasMensagems");
	$router->get('/MinhasCompras', "RotasUser:MinhasCompras");
	$router->get('/DetalhesMensagens', "RotasUser:DetalhesMensagens");
	$router->get('/MeuPerfil', "RotasUser:MeuPerfil");
	$router->get('/MinhaConta', "RotasUser:MinhaConta");
	//------------------------------------------------------------------------------------------------------------------------------------
	$router->namespace("Controladores\Rotas");
	$router->group("estaticos");
	$router->get('/fotoPerfilUser/{idUser}',"RotasSecundarias:fotoUsuario"); // ROTA PARA RECUPERAR IMAGENS DE PERFIL DE UM USUARIO, É PELO ID DELE
	$router->get('/estilo', "RotasEstaticas:estilos");
	$router->get('/componentes/{nome}',"RotasEstaticas:elementos");
	$router->get('/imgs/{qual}', "RotasSecundarias:img"); //ESSA AQ CE JÁ SABE
	$router->get('/imgs/mensagem/{idMsg}/{nomeFoto}',"RotasSecundarias:imgMsg"); // ESSA AQ É PRA RECUPERAR IMAGENS DE UMA MENSAGEM, TENQ TER O ID DA MSG E O NOME DA IMAGEM
	$router->get('/js/{contexto}/{nome}', "RotasEstaticas:script");
	$router->get('/js/subdir/{contexto}/{nomeSubDir}/{nomesArquivosSeparadosPorVirgula}',"RotasEstaticas:subdir");
	$router->get('/js/modulos/{contexto}/{scriptPrincipal}/{nomesDosModulosSeparadosPorVirgula}',"RotasEstaticas:scriptModularizado");
	
	$router->namespace("Controladores\Rotas\RotasUser\UserRequests");
	$router->group("usuario");
	$router->post("/login", "UserRequests:login");
	$router->post("/cadastro", "UserRequests:cadastro");
	$router->post("/mensagem", "MensagensRequests:enviarMensagem");
	$router->get('/minhasMensagens',"MensagensRequests:consultarMensagens"); // DAQUI CE VAI RECUPERAR DADOS DAS MENSAGENS DO USUARIO QUE TIVER LOGADO NO MOMENTO	
	$router->get('/finalizadosUsuarioEspecifico',"CarrinhoRequests:finalizados");	
	$router->get('/perfil',"UserRequests:perfil"); // DAQUI CE VAI RECUPARAR DADOS DO USUARIO LOGADO NO MOMENTO
	$router->get('/logoff', "UserRequests:deslogar"); // DAQUI CE VAI DESLOGAR O USUARIO QUE TIVER LOGADO
	$router->get('/minhaMensagem/{idMsg}/{arqvs}',"MensagensRequests:consultarMensagemEspecifica");
	// DAQUI CE VAI CONSULTAR UMA MENSAGEM ESPECIFICA, ESSA É PRAS TELAS DO USUARIO.
	//pra buscar os arquivos da mensagem tenq passar um sim no final da requisição. se quizer dps explica,
	//mas vai lendo a função MensagensRequests:consultarMensagemEspecifica
/*--------------------------------------------------------------------------------------------------------------------------------------------*/
	$router->namespace("Controladores\Rotas\RotasAdm");
	$router->group("admin");
	$router->get("/", "RotasAdm:inicio");
	$router->get("/cadastroProduto", "RotasAdm:cadastroProduto");
	$router->get("/consulta", "RotasAdm:consultaProduto");
	$router->get("/pedidos", "RotasAdm:pedidos");
	$router->get("/detalhesPedidos", "RotasAdm:detalhesPedidos");
	$router->get("/mensagens", "RotasAdm:mensagens");
	$router->get("/detalhesMensagens", "RotasAdm:detalhesMensagens");
	$router->get("/consultarUsuario", "RotasAdm:consultarUsuario");
	$router->get("/cadastrarClassificacao", "RotasAdm:cadastroClassificacao");
	$router->get("/consultaClassificacao", "RotasAdm:consultaClass");
	$router->get("/cadastroVariacao", "RotasAdm:cadastroVariacao");
	$router->get("/consultaVariacao", "RotasAdm:consultaVariacao");
	$router->get("/erros", "RotasAdm:consultaErros");

	$router->namespace("Controladores\Rotas\RotasAdm\AdmRequests");
	$router->group("envio");
	$router->post("/cadastrarClassificacao", "ClassificacoesRequests:cadastrar");
	$router->post("/editarClassificacao", "ClassificacoesRequests:edicao");
	$router->post("/excluirClassificacao", "ClassificacoesRequests:excluir");
	$router->get("/consultarClassificacoes", "ClassificacoesRequests:consultar");
	$router->get("/atualizarClassificacoes", "ClassificacoesRequests:atualizarArqv");
	$router->get("/consultaMensagens", "MensagensRequests:todas");
	$router->get("/usuarioEspecifico/{idUser}","MensagensRequests:usuarioEspecifico");
	$router->get("/visualizarMensagem/{idMsg}", "MensagensRequests:visualizarMsg");
	
	$router->group("produto");
	$router->post("/excluirProduto","ProdutoRequests:excluirProduto");
	$router->post("/cadastrarProduto", "ProdutoRequests:cadastrarProduto");
	$router->post("/editarTodosOsDados", "ProdutoRequests:editarTodosDados");
	$router->post("/criarDadoSecundario", "ProdutoRequests:criarDadoSecundario");
	$router->post("/editarDadoSecundario", "ProdutoRequests:editarDadoSecundario");
	$router->post("/excluirVariacao", "ProdutoRequests:excluirVariacao");
	
/*------------------------------------------------------------------------------------------------------------------------------------------------*/
	$router->group("ops");
	$router->get("/{erro}", function($data){
		echo "erro ".$data['erro'];
	});
	$router->dispatch();
	if($router->error()){
		$router->redirect("/ops/{$router->error()}");
	}
