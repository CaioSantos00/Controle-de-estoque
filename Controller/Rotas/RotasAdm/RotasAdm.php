<?php
	namespace Controladores\Rotas\RotasAdm;
	use Controladores\Rotas\Controlador;
	use MatthiasMullie\Minify as M;

	class RotasAdm extends Controlador{
		function __construct(){
			parent::__construct();
			if(!isset($_COOKIE['TipoConta'])) header("location: http://localhost/");
			//exit("sai fora, Hacker!");
		}
		function inicio($data){
			parent::renderizar("pagesAdm/painelPerfilAdm.html");
		}
		function cadastroProduto($data){
			parent::renderizar("pagesAdm/cadastroProduto.html");
		}
		function consultaProduto($data){
			parent::renderizar("pagesAdm/consultaProduct.html");
		}
		function consultaErros($data){
			parent::renderizar("pagesAdm/errorAdm.html");
		}
		function pedidos($data){
			parent::renderizar("pagesAdm/pedidos.html");
		}
		function detalhesPedidos($data){
			parent::renderizar("pagesAdm/pedidosDetalhes.html");
		}
		function mensagens($data){
			parent::renderizar("pagesAdm/mensagens.html");
		}
		function detalhesMensagens($data){
			parent::renderizar("pagesAdm/detailsMensagens.html");
		}
		function consultarUsuario($data){
			parent::renderizar("pagesAdm/consultaUser.html");
		}
		function cadastroClassificacao($data){
			parent::renderizar("pagesAdm/cadastroClassificacao.html");
		}
		function consultaClass($data){
			parent::renderizar("pagesAdm/consultaClass.html");
		}		
		function cadastroVariacao($data){
			parent::renderizar("pagesAdm/cadastroVariacao.html");
		}
		function consultaVariacao($data){
			parent::renderizar("pagesAdm/consultaVar.html");
		}

			/*
			$minificador = new M\JS();
			$scripts = explode(',',$data['nomesDosModulosSeparadosPorVirgula']);
			foreach($scripts as $script){
				$minificador->add(parent::renderizar("RecursosEstaticos/js/{$data['contexto']}/Modulos/{$script}.js", true));
			}
			$minificador->add(parent::renderizar("RecursosEstaticos/js/{$data['contexto']}/{$data['scriptPrincipal']}.js", true));
			echo $minificador->minify();
			*/
		
	}
