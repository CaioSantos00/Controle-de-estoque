<?php
	namespace Controladores\Rotas;
	use Intervention\Image\ImageManagerStatic as Img;

	class RotasSecundarias{
		private function renderizar(string $nome){
			if(file_exists($nome))
				echo Img::make($nome)->response();
		}
		function fotoUsuario($data){
			$this->renderizar("arqvsSecundarios/FotosUsuarios/{$data['idUser']}");
		}
		function img($data){
			$this->renderizar("View/imgs/{$data['qual']}");
		}
	}
