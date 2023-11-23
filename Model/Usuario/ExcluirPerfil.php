<?php
	namespace App\Usuario;

	use App\Servicos\Conexao\ConexaoBanco as CB;
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
		private function excluirDoBanco() :bool{
			try{
				$resultado = true;
				CB::getConexao()->beginTransaction();
				$query = CB::getConexao()->prepare("delete from `usuario` where `Id`= ?");
				$excluido = $query->execute();
				if(!$excluido) throw new \Exception("não excluiu como deveria");
				CB::getConexao()->commit();
			}
			catch(\Exception|\PDOException $e){
				CB::voltaTudo();
				$GLOBALS['ERRO']->setErro("exclusão usuario", $e->getMessage());
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
		function executar(){
			if($this->excluirDoBanco()) return $this->excluirFoto();
			return false;
		}
	}
