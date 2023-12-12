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
	$router->get('/CadastrarEndereco', "RotasUser:CadastrarEndereco");
	$router->get('/FinalCarrinho', "RotasUser:FinalCarrinho");
	$router->get('/MinhasMensagens', "RotasUser:MinhasMensagems");
	$router->get('/MinhasCompras', "RotasUser:MinhasCompras");
	$router->get('/DetalhesMensagens', "RotasUser:DetalhesMensagens");
	$router->get('/MeuPerfil', "RotasUser:MeuPerfil");
	$router->get('/MinhaConta', "RotasUser:MinhaConta");
	$router->get('/ConsultarEndereco', "RotasUser:ConsultarEndereco");
	$router->get('/MeusEnderecos', "RotasUser:MeusEnderecos");
	//------------------------------------------------------------------------------------------------------------------------------------
	$router->namespace("Controladores\Rotas");
	$router->group("estaticos");
	$router->get('/fotoPerfilUser/{idUser}',"RotasSecundarias:fotoUsuario");
	$router->get('/estilo', "RotasEstaticas:estilos");
	$router->get('/componentes/{nome}',"RotasEstaticas:elementos");
	$router->get('/imgs/{qual}', "RotasSecundarias:img");
	$router->get('/imgs/variacao/{idPrimario}/{idVariacao}/{nomeImagem}', "RotasSecundarias:imgVariacao");
	$router->get('/imgs/mensagem/{idMsg}/{nomeFoto}',"RotasSecundarias:imgMsg");
	// ESSA AQ É PRA RECUPERAR IMAGENS DE UMA MENSAGEM, TENQ TER O ID DA MSG E O NOME DA IMAGEM
	$router->get('/js/{contexto}/{nome}', "RotasEstaticas:script");
	$router->get('/js/subdir/{contexto}/{nomeSubDir}/{nomesArquivosSeparadosPorVirgula}',"RotasEstaticas:subdir");
	$router->get('/js/modulos/{contexto}/{scriptPrincipal}/{nomesDosModulosSeparadosPorVirgula}',"RotasEstaticas:scriptModularizado");

	$router->namespace("Controladores\Rotas\RotasUser\UserRequests");
	$router->group("usuario");
	$router->post("/login", "UserRequests:login");
	$router->post("/editar", "UserRequests:editar");
	$router->post("/cadastro", "UserRequests:cadastro");
	$router->get('/perfil',"UserRequests:perfil");
	$router->get('/perfilMensagem',"UserRequests:perfilMsg");
	$router->get('/perfilEdicao',"UserRequests:consultaDadosPraEdicao");
	// DAQUI CE VAI RECUPARAR DADOS DO USUARIO LOGADO NO MOMENTO
	// DAQUI CE VAI DESLOGAR O USUARIO QUE TIVER LOGADO
	$router->get('/logoff', "UserRequests:deslogar");

	$router->group("mensagens");
	$router->post("/enviarMensagem", "MensagensRequests:enviarMensagem");
	$router->get('/minhasMensagens',"MensagensRequests:consultarMensagens");
	// DAQUI CE VAI RECUPERAR DADOS DAS MENSAGENS DO USUARIO QUE TIVER LOGADO NO MOMENTO
	$router->get('/minhaMensagem/{idMsg}/{arqvs}',"MensagensRequests:consultarMensagemEspecifica");
	// DAQUI CE VAI CONSULTAR UMA MENSAGEM ESPECIFICA, ESSA É PRAS TELAS DO USUARIO.
	//pra buscar os arquivos da mensagem tenq passar um sim no final da requisição. se quizer dps explica,
	//mas vai lendo a função consultarMensagemEspecifica do arquivo MensagensRequests da parte de usuario

	$router->group("carrinho");
	$router->get("/consultar","CarrinhoRequests:consultar");
	//Consulta do carrinho do usuário que estiver logado no momento
	$router->get("/adicionar/{idVariacao}/{qtd}","CarrinhoRequests:adicionarItem");
	// Aqui é pra adicionar um item no carrinho do usuário logado, tenq passar o id da variação e a quantidade.
	$router->get("/removerItem/{idVariacao}/{qtd}","CarrinhoRequests:removerItem");
	//Aqui é pra remover ou diminuir a quantidade de um item no carrinho do usuário logado, tenq passar o id da variação e a quantidade.
	$router->get("/finalizar/{IdEndereco}","CarrinhoRequests:finalizar");
	//Aqui é pra finalizar o carrinho do usuário logado no momento
	$router->get('/finalizados',"CarrinhoRequests:finalizados");
	//Aqui é pra consultar os carrinhos finalizados do usuario logado no momento

	$router->group("endereco");
	$router->post("/cadastrar", "EnderecoRequests:cadastrar");
	$router->get("/consultar", "EnderecoRequests:consultar");
	$router->post("/excluir", "EnderecoRequests:excluir");
	$router->post("/editar", "EnderecoRequests:editar");
	$router->get("/consultarEsse/{id}", "EnderecoRequests:consultarEsse");

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
	$router->group("admin/classificacoes");
	$router->post("/cadastrarClassificacao", "ClassificacoesRequests:cadastrar");
	$router->post("/editarClassificacao", "ClassificacoesRequests:edicao");
	$router->post("/excluirClassificacao", "ClassificacoesRequests:excluir");
	$router->get("/atualizarClassificacoes", "ClassificacoesRequests:atualizarArqv");

	$router->group("classificacoes");
	$router->get("/consultarClassificacoes", "ClassificacoesRequests:consultar");

	$router->group("admin/carrinhos");
	$router->get("/consultarCarrinhoFinalizados","AdmRequests:consultarCarrinhosFinalizados");

	$router->group("admin/consulta");
	$router->get("/consultarProdutosPrimarios", "AdmRequests:consultarProdutosPrimarios");
	$router->get("/consultaProdutoGeral", "AdmRequests:consultarProdutos");

	$router->group("admin/mensagens");
	//Todos os carrinhos finalizados de todos os usuários
	$router->get("/consultaMensagens", "MensagensRequests:todas");
	// Todas as mensagens de todos os usuários
	$router->get("/usuarioEspecifico/{idUser}","MensagensRequests:usuarioEspecifico");
	// Todas as mensagens de um usuário específico, mas para a parte de admin
	$router->get("/visualizarMensagem/{idMsg}", "MensagensRequests:visualizarMsg");
	//marca a mensagem como visualizada
	$router->get("/infoMsgEspecifica/{idMsg}", "MensagensRequests:mensagemEspecifica");
	// Informações de uma mensagem específica para a parte de admin

	$router->group("produto");
	$router->get("/consultar/{idPrimario}", "AdmRequests:consultarProduto");
	$router->get("/consultarEsse/{idVariacao}","AdmRequests:consultarVariacao");
	$router->get("/consultarTodos", "AdmRequests:consultarProdutos");
	$router->post("/excluirProduto","ProdutoRequests:excluirProduto");
	$router->post("/cadastrarProduto", "ProdutoRequests:cadastrarProduto");
	$router->post("/editarTodosOsDados", "ProdutoRequests:editarTodosDados");
	$router->post("/criarDadoSecundario", "ProdutoRequests:criarDadoSecundario");
	$router->post("/editarDadoSecundario", "ProdutoRequests:editarDadoSecundario");
	$router->post("/excluirVariacao", "ProdutoRequests:excluirVariacao");
	$router->post("/salvarPrincipais", "ProdutoRequests:salvarDadosPrincipais");

/*------------------------------------------------------------------------------------------------------------------------------------------------*/
	$router->group("ops");
	$router->get("/{erro}", function($data){
		echo "erro ".$data['erro'];
	});
	$router->dispatch();
	if($router->error()){
		$router->redirect("/ops/{$router->error()}");
	}
