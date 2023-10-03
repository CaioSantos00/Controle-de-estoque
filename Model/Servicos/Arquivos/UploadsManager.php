<?php
	namespace App\Servicos\Arquivos;

	use Intervention\Image\ImageManagerStatic as Image;

	class UploadsManager{
		const CAMINHO_ARQUIVOS_SECUNDARIOS = "arqvsSecundarios/";
		static private bool $resultado = true;

		private static function testarResultado(string $mensagemPraExcecao, bool $paraTestar = false){
			if(self::$resultado === $paraTestar) throw new Exception($mensagemPraExcecao);
		}

		static function salvarImagemDePerfilEnviada(string $idUsuario) :bool{
			try{
				$destinoDoArquivo = self::CAMINHO_ARQUIVOS_SECUNDARIOS."FotosUsuarios/".$_FILES['fotoUsuario']['name'];

				self::$resultado = move_uploaded_file(
					$_FILES['fotoUsuario']['tmp_name'],
					$destinoDoArquivo
				);
				self::testarResultado('no envio do arquivo para seu devido diretório');
				
				$novoNome = self::CAMINHO_ARQUIVOS_SECUNDARIOS."FotosUsuarios/".$idUsuario.".".explode('/',$_FILES['fotoUsuario']['type'])[1];
				
				self::$resultado = rename($destinoDoArquivo,$novoNome);
				
				self::testarResultado('na mudança do nome da imagem');

				$destinoDoArquivo = self::CAMINHO_ARQUIVOS_SECUNDARIOS."FotosUsuarios/".$idUsuario;

				$imagem = Image::make($novoNome)
					->resize(300,300);//Redimensiona a imagem para um tamanho padrão
					
				$imagem->save($destinoDoArquivo,80, "png"); 

				self::testarResultado('no envio do arquivo para seu diretório');
			}
			catch(Exception $ex){
				$GLOBALS['ERRO']->setErro('Cadastro Usuario', "No envio da Foto do usuário, {$ex->getMessage()}");
				self::$resultado = false;
			}
			finally{
				return self::$resultado;
			}
		}
	}