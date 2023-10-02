<?php
	namespace Controladores\Rotas\RotasUser;	
	
	use League\Plates\Engine;
	
	class RotasUser{
		private Engine $templates;
		public function __construct(){
			$this->templates = new Engine ('View/pages');
			$this->templates->setFileExtension(null);			
		}
		public function home($data){
			echo $this->templates->render('index.html');
		}
		public function login($data){
			echo $this->templates->render('login.html');
		}
		public function cadastro($data){
			echo $this->templates->render('cadastro.html');
		}
		public function sobre($data){
			echo $this->templates->render('sobre.html');
		}
	}