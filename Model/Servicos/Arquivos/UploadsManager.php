<?php
	namespace Servicos\Arquivos;
	
	use Intervention\Image\ImageManagerStatic as Image;
	
	class UploadsManager{
		static const $caminhoParaArvsSecund = "../../../ArquivosSecundarios"
		static function salvarImagemDePerfilEnviada(string $idUsuario){
			$caminhoParaDiretorio
			$destino = self::"/FotosUsuarios/".$_FILES['fotoUsuario']['name'];
			
			$imagem = Image::make($_FILES['fotoUsuario']['tmp_name']);
			$imagem
			->resize(300,300) //Redimensiona a imagem para um tamanho padrão
			->encode("png", 70) //Define para uma extensão padrão e reduz a qualidade (para fins de compressão)
			->save(); // Salvando na mesma instancia, alteramos a imagem original sem movê-la
			
			move_uploaded_file(
				$_FILES['fotoUsuario']['tmp_name'],
				$destino
			);
			
			rename($destino, )
		}
	}