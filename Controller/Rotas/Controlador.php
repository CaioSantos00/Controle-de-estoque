<?php
	namespace Controladores\Rotas;

	use League\Plates\Engine;

	class Controlador{
		private Engine $templates;

		function __construct(){
			$this->templates = new Engine('View');
			$this->templates->setFileExtension(null);
		}		
		protected function renderizar(string $nomeTemplate){
			try{
				$this->templateParaRenderizar = $this->templates->make($nomeTemplate);
				echo $this->templateParaRenderizar->render();
			}
			catch(\Exception $ex){
				$GLOBALS['ERRO']->setErro("renderização de template", "na chamada do template {$nomeTemplate}, {$ex->getMessage()}");
				echo "não encontrado";
			}
		}
	}