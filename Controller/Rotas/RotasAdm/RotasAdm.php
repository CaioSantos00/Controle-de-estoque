<?php
	namespace Controladores\Rotas\RotasAdm;
	use Controladores\Rotas\Controlador;
	use MatthiasMullie\Minify as M;

	class RotasAdm extends Controlador{
		function __construct(){
			parent::__construct();
			if(!isset($_COOKIE['TipoConta'])) exit("sai fora, Hacker!");
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
		public function estilos($data){
			header('Content-type: text/css');
			$minificador = new M\CSS();
			$minificador->add(parent::renderizar('RecursosEstaticos/css/style.css', true));
			echo $minificador->minify();
		}
		public function img($data){
			parent::renderizar('RecursosEstaticos/imgs/'.$data['qual']);
		}
		public function script($data){
			header('Content-type: application/javascript');
			$minificador = new M\JS();
			$minificador->add(parent::renderizar("RecursosEstaticos/js/{$data['contexto']}/{$data['nome']}",true));
			echo $minificador->minify();
		}
		public function elementos($data){
			parent::renderizar("components/{$data['nome']}.html");
		}
		public function scriptModularizado($data){
			header('Content-type: application/javascript');
			$minificador = new M\JS();
			$scripts = explode(',',$data['nomesDosModulosSeparadosPorVirgula']);
			foreach($scripts as $script){
				$minificador->add(parent::renderizar("RecursosEstaticos/js/{$data['contexto']}/Modulos/{$script}.js", true));
			}
			$minificador->add(parent::renderizar("RecursosEstaticos/js/{$data['contexto']}/{$data['scriptPrincipal']}.js", true));
			echo $minificador->minify();
		}
	}
