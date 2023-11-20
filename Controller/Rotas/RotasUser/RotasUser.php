<?php
	namespace Controladores\Rotas\RotasUser;	
	use Controladores\Rotas\Controlador;	
	
	class RotasUser extends Controlador{		
		
		function __construct(){
			parent::__construct();	
		}		
		public function home($data){
			parent::renderizar('pages/inicio.html');
		}
		public function login($data){
			parent::renderizar('pages/login.html');
		}
		public function sobre($data){
			parent::renderizar('pages/sobre.html');
		}
		public function produtos($data){
			parent::renderizar('pages/produtos.html');
		}
		public function cadastro($data){
			parent::renderizar('pages/cadastro.html');
		}
		public function telaMsgs($data){
			parent::renderizar('pages/telaMensagens.html');
		}
	}