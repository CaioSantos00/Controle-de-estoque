<?php
	namespace App\Servicos\Arquivos\PerfilUsuario;
	
	use App\Interfaces\ServicoInterno;
	use App\Servicos\Arquivos\UploadsManager;
	
	class Buscar extends UploadsManager implements ServicoInterno{
		protected string $nomeImagem;
		private string $caminhoImagemPerfil = "arqvsSecundarios/FotosUsuarios";
		function __construct(string $idUsuario){
			$this->nomeImagem = $idUsuario.".png";
		}
		private function verificaExistenciaDeFoto() :bool{
			$fotos = array_diff(
				scandir($this->caminhoImagemPerfil),
				['.','..']
			);
			return in_array($this->nomeImagem, $fotos);
		}
		function executar() :string{
			if($this->verificaExistenciaDeFoto()) return $this->nomeImagem;
			return "";
		}
	}