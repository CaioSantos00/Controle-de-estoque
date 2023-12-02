<?php
	namespace App\Mensagem;

	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\Model;

	class VisualizarMensagem implements Model{
		private string $idMsg;
		private string $query = "update `mensagens` set `Status` = 'lida' where `Id` = ?";
		function __construct(string $idMsg){
			$this->idMsg = $idMsg;
		}
		private function executaQuery() :bool{
			try{
				$query = CB::getConexao()->prepare($this->query);
				$query->execute([$this->idMsg]);
				return true;
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro("visualizacao mensagem", $e->getMessage());
				return false;
			}
		}
		function getResposta(){
			return $this->executaQuery();
		}
	}