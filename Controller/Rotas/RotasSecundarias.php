<?php
	namespace Controladores\Rotas;
	use Intervention\Image\ImageManagerStatic as Img;

	class RotasSecundarias{
		private function renderizar(string $nome){
			try{
				if(file_exists($nome))
				echo Img::make($nome)->response();
			}
			catch(\Exception $e){
				echo 'erro interno';
				$GLOBALS['ERRO']->setErro("alguma Imagem", $e->getMessage());
			}
		}
		function fotoUsuario($data){
			$this->renderizar("arqvsSecundarios/FotosUsuarios/{$data['idUser']}.png");
		}
		function img($data){
			$this->renderizar("View/imgs/{$data['qual']}");
		}		
	}
