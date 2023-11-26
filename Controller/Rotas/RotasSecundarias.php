<?php
	namespace Controladores\Rotas;	
	
	use League\Plates\Engine;
	
	class RotasSecundarias{
		private Engine $templates;
		function __construct(){
			$this->templates = new Engine('arqvsSecundarios');
			$this->templates->setFileExtension(null);			
		}
		private function renderizar(string $nome){
			try{
				echo $this->templates->render($nome);
			}
			catch(\Exception $ex){
				$GLOBALS['ERRO']->setErro("renderização de template", "na chamada do template {$nome}, {$ex->getMessage()}");
				echo "não encontrado";			
			}
		}
		function fotoUsuario($data){
			$this->renderizar("FotosUsuarios/{$data['idUser']}.png");
		}
	}
	