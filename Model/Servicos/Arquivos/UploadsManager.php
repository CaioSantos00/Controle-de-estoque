<?php
	namespace Servicos\Arquivos;

	use Intervention\Image\ImageManagerStatic as Image;

	class UploadsManager{
		static const $caminhoParaArvsSecund = "../../../ArquivosSecundarios";
		static private bool $resultado = true;

		private static function testarResultado(string $mensagemPraExcecao, bool $paraTestar = false){
			if(self::$resultado === $paraTestar) throw new Exception($mensagemPraExcecao);
		}

		static function salvarImagemDePerfilEnviada(string $idUsuario) :bool{
			try{
				$destinoDoArquivo = self::$caminhoParaArvsSecund."/FotosUsuarios/".$_FILES['fotosUsuarios']['tmp_name'];

				self::$resultado = rename(
					$_FILES['fotoUsuario']['tmp_name'],
					$idUsuario //Renomeia o nome do arquivo para o Id do usuário
				);

				self::testarResultado('na mudança do nome da imagem');

				$imagem = Image::make($_FILES['fotoUsuario']['tmp_name']);
				$imagem
					->resize(300,300) //Redimensiona a imagem para um tamanho padrão
					->encode("png", 70) //Define para uma extensão padrão e reduz a qualidade (para fins de compressão)
					->save(); // Salvando na mesma instancia, alteramos a imagem original sem movê-la

				self::$resultado = move_uploaded_file(
					$_FILES['fotoUsuario']['tmp_name'],
					$destinoDoArquivo
				);

				self::testarResultado('no envio do arquivo para seu diretório');
			}
			catch(Exception $ex){
				$GLOBALS['ERRO']->setErro('Cadastro Usuario', "No envio da Foto do usuário, {$ex->getMessage()}");
				self::$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
	}