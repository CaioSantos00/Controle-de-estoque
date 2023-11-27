<?php
	namespace App\Servicos\Arquivos;

	use Intervention\Image\ImageManagerStatic as ImageManager;

	class UploadsManager{
		protected string $caminhoArqvsSecundarios = "arqvsSecundarios/";
		protected bool $resposta;

		protected function testarResposta(string $mensagemPraExcecao, bool $paraTestar = false){
			if($this->resposta === $paraTestar) throw new \Exception($mensagemPraExcecao);
		}

		protected function getInterventionImageInstance(string $linkImagem){
			return ImageManager::make($linkImagem);
		}
	}
