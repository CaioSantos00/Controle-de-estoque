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
			echo $this->templates->render('pages/index.html');
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
		public function estilo($data){			
			header("Content-type: text/css");
			echo $this->templates->render('RecursosEstaticos/css/style.css');
		}
		public function img($data){
			echo $this->templates->render('RecursosEstaticos/imgs/'.$data['qual']);			
		}/*
		public function scripts($data){
			echo $this->templates->render('RecursosEstaticos/scripts/'.$data['qual']);
		}*/
	}