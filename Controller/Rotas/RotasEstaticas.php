<?php
	namespace Controladores\Rotas;	
	use Controladores\Rotas\Controlador;	
	
	class RotasEstaticas extends Controlador{
		public function __construct(){
			parent::__construct();
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