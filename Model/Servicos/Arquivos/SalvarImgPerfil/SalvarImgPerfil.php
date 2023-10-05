<?php
    namespace App\Servicos\Arquivos\SalvarImgPerfil;

    use Intervention\Image\ImageManagerStatic as Image;
    use App\Servicos\Arquivos\UploadsManager;
    use App\Model;

    class SalvarImgPerfil extends UploadsManager implements Model{
        private string $destinoDoArquivo;
        private string $idUsuario;
        private string $nomeParaSalvarArquivo;

        function __construct($idUsuario){
            $this->idUsuario = $idUsuario;
        }
        private function moverParaDiretorio(){
            parent::$resposta = move_uploaded_file(
				$_FILES['fotoUsuario']['tmp_name'],
				$this->destinoDoArquivo
			);
			parent::testarResposta('no envio do arquivo para seu devido diretório');
        }
        private function renomeiaParaIdDoDono(){            
            $this->nomeParaSalvarArquivo = parent::$caminhoArqvsSecundarios."FotosUsuarios/".$this->idUsuario;
			parent::$resposta = rename($this->destinoDoArquivo,$this->nomeParaSalvarArquivo);
			parent::testarResposta('na mudança do nome da imagem');            
        }
        private function salvaFormatoPadrao(){
            $imagem = Image::make($this->nomeParaSalvarArquivo); //Gera instancia da Classe
			$imagem->resize(300,300);//Redimensiona a imagem para um tamanho padrão
			$imagem->save($this->destinoDoArquivo,80, "png"); //Salva com uma extensão padrão e qualidade reduzida

            parent::testarResposta('no envio do arquivo para seu diretório');
        }
        function salvarImagemEnviada(){
			try{
                $this->destinoDoArquivo = parent::$caminhoArqvsSecundarios."FotosUsuarios/".$_FILES['fotoUsuario']['name'];
                $this->moverParaDiretorio();
                $this->renomeiaParaIdDoDono($this->idUsuario);
				$this->destinoDoArquivo = self::$caminhoArqvsSecundarios."FotosUsuarios/".$this->idUsuario;
                $this->salvaFormatoPadrao();
			}
			catch(Exception $ex){
				$GLOBALS['ERRO']->setErro('Cadastro Usuario', "No envio da Foto do usuário, {$ex->getMessage()}");
				parent::$resposta = false;
			}			
		}
        function getResposta() :string{
            return parent::$resposta;
        }
    }