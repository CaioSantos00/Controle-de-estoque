<?php
	namespace App\Mensagem;

	use App\Interfaces\Model;
	use App\Conexao\ConexaoBanco as CB;
	use App\Servicos\Arquivos\Mensagens\SalvarImagem as SI;

	class EnviarMensagem implements Model{
		public string $idMensagem;
		private string $query = "insert into `mensagens`(`parentId`, `conteudo`, `DataEnvio`) values(?,?,?)";
		private string $conteudo;
		private string $idUsuario;
		function __construct(string $idUsuario, string $conteudo){
			$this->idUsuario = $idUsuario;
			$this->conteudo = $conteudo;
		}
		private function salvarNoBanco() :bool{
			try{
				$resultado = false;
				$query = CB::getConexao()->prepare($this->query);
				if(!$query->execute([$this->idUsuario, $this->conteudo, date("d.m.y \\ g:i")])) return;
				$this->idMensagem = CB::getConexao()->lastInsertId();
				$resultado = true;
			}
			catch(\Exception|\PDOException $e){
				$GLOBALS['ERRO']->setErro("Mensagem", $e->getMessage());
				CB::voltaTudo();
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
		private function salvarImagens(){
			$salvar = new SI($this->idUsuario, $this->idMensagem);
			return $salvar->executar();
		}
		function getResposta(){
			if($this->salvarNoBanco()) return $this->salvarImagens();
			return false;
		}
	}
