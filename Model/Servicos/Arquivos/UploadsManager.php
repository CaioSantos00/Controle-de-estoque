<?php
	namespace App\Servicos\Arquivos;
	
	use Intervention\Image\ImageManager;
	
	class UploadsManager{
		protected string $caminhoArqvsSecundarios = "arqvsSecundarios/";
		protected bool $resposta;
		private $imageManager;
		
		protected function testarResposta(string $mensagemPraExcecao, bool $paraTestar = false){
			if($this->resposta === $paraTestar) throw new Exception($mensagemPraExcecao);
		}
		
		protected function getInterventionImageInstance(){
			if(empty($this->imageManager)){
				$this->imageManager = new ImageManager();				
				return $this->imageManager;
			}
			return $this->imageManager;
		}
	}