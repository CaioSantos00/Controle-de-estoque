<?php
	namespace Controladores\Rotas\RotasUser;	
	
	use League\Plates\Engine;	
	class RotasUser{
		private Engine $templates;
		public function __construct(){
			$this->templates = new Engine('View');
			$this->templates->setFileExtension(null);			
		}
		public function home($data){			
			echo $this->templates->render('pages/inicio.html');
		}
		public function login($data){
			echo $this->templates->render('pages/login.html');
		}
		public function cadastro($data){
			echo $this->templates->render('pages/cadastro.html');
		}
		public function sobre($data){
			echo $this->templates->render('pages/sobre.html');
		}
		public function produtos($data){
			echo $this->templates->render('pages/produtos.html');
		}
		public function telaMensagens($data){
			echo $this->templates->render('pages/telaMensagens.html');
		}
		public function telaError($data){
			echo $this->templates->render('pages/telaErroUser.html');
		}
		public function adm($data){
			echo $this->templates->render('pagesAdm/painelPerfilAdm.html');
		}
		public function errosAdm($data){
			echo $this->templates->render('pagesAdm/errorAdm.html');
		}
		public function estilo($data){			
			header("Content-type: text/css");
			echo $this->templates->render('RecursosEstaticos/css/style.css');
		}
		public function imgs($data){
			echo $this->templates->render('RecursosEstaticos/imgs/'.$data['qual']);			
		}
		public function scripts($data){
			echo $this->templates->render('RecursosEstaticos/js/'.$data['cont']."/".$data['qual']);
		}
	}