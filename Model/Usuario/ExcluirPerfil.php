<?php
	namespace App\Usuario;
	
	use App\Servicos\Conexao\ConexaoBanco;
	use App\Interfaces\ServicoInterno;
	use App\Servicos\Arquivos\PerfilUsuario\ExcluirFoto;
	
	class ExcluirPerfil implements ServicoInterno{
		private string $idUsuario;
		function __construct(string $idUsuario){
			$this->idUsuario = $idUsuario;
		}
		private function excluirFoto() :bool{
			$excluir = new ExcluirFoto($this->idUsuario);
			return $excluir->executar();
		}
	}