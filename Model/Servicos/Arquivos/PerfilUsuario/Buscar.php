<?php
	namespace App\Servicos\Arquivos\PerfilUsuario;
	
	use App\Interfaces\ServicoInterno;
	
	class Buscar implements ServicoInterno{
		private string $caminhoImagemPerfil = "arqvsSecundarios/FotosUsuarios/";
		public bool $temImagem;
		function __construct(string $idUsuario){
			$this->caminhoImagemPerfil .= $idUsuario.".png";
		}
		private function verificaExistenciaDeFoto() :bool{
			return file_exists($this->caminhoImagemPerfil);
		}
		function executar(){
			$this->temImagem = $this->verificaExistenciaDeFoto();
		}
	}