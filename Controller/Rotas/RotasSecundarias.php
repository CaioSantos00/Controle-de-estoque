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
				$GLOBALS['ERRO']->setErro("alguma Imagem", "img: {$nome}, erro: {$e->getMessage()}");
			}
		}
		function fotoUsuario($data){
			$this->renderizar("arqvsSecundarios/FotosUsuarios/{$data['idUser']}.png");
		}
		function img($data){
			$this->renderizar("View/imgs/{$data['qual']}");
		}
		function imgMsg($data){
			if(!is_numeric($data['idMsg'])) exit("erro interno");
				$this->renderizar("arqvsSecundarios/Mensagens/{$data['idMsg']}/{$data['nomeFoto']}");
		}
		function imgVariacao($data){
			if(!is_numeric($data['idPrimario']) or !is_numeric($data['idVariacao'])) exit("erro interno");
			$this->renderizar("arqvsSecundarios/Produtos/Fotos/{$data['idPrimario']}/Secundarias/{$data['idVariacao']}/{nomeImagem}");
		}
	}
