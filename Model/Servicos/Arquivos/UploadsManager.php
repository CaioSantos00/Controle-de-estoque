<?php
	namespace Servicos\Arquivos;
	
	use Intervention\Image\ImageManagerStatic as Image;
	
	class UploadsManager{
		static const $caminhoParaArvsSecund = "../../../ArquivosSecundarios"
		
		static function salvarImagemDePerfilEnviada(string $idUsuario) :bool{			
			try{
				$resultado = true;
				
				$destino = self::$caminhoParaArvsSecund."/FotosUsuarios/";
				
				$resultado = rename(
					$_FILES['fotoUsuario']['tmp_name'],
					$idUsuario //Renomeia o nome do arquivo para o Id do usuário
				);
				
				if($resultado === false) throw new Exception('na mudança de nome');				
				
				$imagem = Image::make($_FILES['fotoUsuario']['tmp_name']);
				$imagem 
					->resize(300,300) //Redimensiona a imagem para um tamanho padrão
					->encode("png", 70) //Define para uma extensão padrão e reduz a qualidade (para fins de compressão)
					->save(); // Salvando na mesma instancia, alteramos a imagem original sem movê-la
				
				move_uploaded_file(
					$_FILES['fotoUsuario']['tmp_name'],
					$destino.$_FILES['fotosUsuarios']['tmp_name']
				);
				
				if($resultado === false) throw new Exception('no envio do arquivo para seu diretório');
				
			}
			catch(Exception $ex){
				$GLOBALS['ERRO']->setErro('Cadastro Usuario', "No envio da Foto do usuário, {$ex->getMessage()}");
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}		
	}