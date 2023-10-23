<?php
	namespace Controladores\Rotas\RotasAdm;
	use Controladores\Rotas\Controlador;
	
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
			parent::renderizar('RecursosEstaticos/css/style.css');
		}
		public function img($data){
			parent::renderizar('RecursosEstaticos/imgs/'.$data['qual']);
		}
		public function script($data){
			header('Content-type: application/javascript');			
			parent::renderizar("RecursosEstaticos/js/{$data['contexto']}/{$data['nome']}");
		}
		public function elementos($data){
			parent::renderizar("components/{$data['nome']}.html");
		}
		public function scriptModularizado($data){
			header('Content-type: application/javascript');			
			$scripts = explode(',',$data['nomesDosModulosSeparadosPorVirgula']);			
			foreach($scripts as $script){
				parent::renderizar("RecursosEstaticos/js/{$data['contexto']}/Modulos/{$script}.js");
			}
			parent::renderizar("RecursosEstaticos/js/{$data['contexto']}/{$data['scriptPrincipal']}.js");
		}
	}