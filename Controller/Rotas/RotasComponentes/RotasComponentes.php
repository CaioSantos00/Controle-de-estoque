<?php
	namespace Controladores\Rotas\RotasComponentes;	
	
	use League\Plates\Engine;	

	class RotasComponentes{
		private Engine $templates;
		public function __construct(){
			$this->templates = new Engine('View/components');
			$this->templates->setFileExtension(null);			
		}		
		public function header($data){
            echo $this->templates->render('header.html');
        }        
	}