<?php
    namespace App\Servicos\Arquivos\PerfilUsuario;
    
    use App\Servicos\Arquivos\UploadsManager;
    use App\Interfaces\ServicoInterno;
    
    class Salvar extends UploadsManager implements ServicoInterno{
        private string $destinoDoArquivo;
        private string $idUsuario;
        private string $nomeParaSalvarArquivo;
        
        function setIdUsuario(string $idUsuario){
            $this->idUsuario = $idUsuario;
            $nomeFoto = explode(".",basename($_FILES['fotoUsuario']['name']));
            $nomeFoto = $nomeFoto[count($nomeFoto) - 2];
            $this->destinoDoArquivo =
                $this->caminhoArqvsSecundarios."FotosUsuarios/".$nomeFoto;        
        }        
        private function salvaFormatoPadrao(){            
            $imagem = $this->getInterventionImageInstance($_FILES['fotoUsuario']['tmp_name']); //Gera instancia da Classe
            $imagem->fit(300, 300);//Redimensiona a imagem para um tamanho padrão
            $imagem->save($this->destinoDoArquivo, 80, 'png');
        }        
        private function renomeiaParaIdDoDono(){            
            $this->nomeParaSalvarArquivo = $this->caminhoArqvsSecundarios."FotosUsuarios/".$this->idUsuario.".png";
			$this->resposta = rename($this->destinoDoArquivo,$this->nomeParaSalvarArquivo);
			$this->testarResposta('na mudança do nome da imagem');            
        }
        function executar(){
			try{                
                $this->salvaFormatoPadrao();  
                $this->renomeiaParaIdDoDono();
			}
			catch(\Exception $ex){
				$GLOBALS['ERRO']->setErro('Cadastro Usuario', "No envio da Foto do usuário, {$ex->getMessage()}");
				$this->resposta = false;
			}			
		}
        function getResposta() :bool{
            return $this->resposta;
        }
    }