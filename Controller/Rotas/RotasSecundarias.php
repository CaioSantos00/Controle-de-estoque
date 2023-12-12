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
		function imgVariacaoPorId($data){
			if(!is_numeric($data['idPrimario']) or !is_numeric($data['idVariacao'])) exit("erro interno");
			$dir = "arqvsSecundarios/Produtos/Fotos/{$data['idPrimario']}/Secundarias/{$data['idVariacao']}";
            if(!is_dir($dir)) exit("nn tem");
            $fotos = array_values(
                array_diff(
                    scandir($dir),
                    ['.','..']
                )
            );
			echo json_encode($fotos)
		}
		function imgVariacao($data){
			if(!is_numeric($data['idPrimario']) or !is_numeric($data['idVariacao'])) exit("erro interno");
			$this->renderizar("arqvsSecundarios/Produtos/Fotos/{$data['idPrimario']}/Secundarias/{$data['idVariacao']}/{nomeImagem}");
		}
	}
