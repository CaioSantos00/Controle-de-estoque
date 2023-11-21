<?php
	namespace App\Mensagem\Consultar;
	
	use App\Interfaces\{Model,Mostravel};
	use App\Mensagem\Consultar\Especifica;
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Exceptions\UserException;
	
	class UsuarioEspecifico implements Model{
		private string $idUsuario;
		private array $idMensagens;
		private string $msgErro;
		private string $query = "select `Id` from `mensagens` where `parentId` = ?";
		function __construct(string $idUsuario){
			$this->idUsuario = $idUsuario;
		}
		private function getIdsMensagensDoUsuario() :bool{
			try{
				$resultado = true;
				$query = CB::getConexao()->prepare($this->query);				
				if(!$query->execute([$this->idUsuario])) throw new UserException("erro muito interno");
				$this->idMensagens = $query->fetchAll();
				if(count($this->idMensagens) == 0) throw new UserException("sem mensagens desse usuario");
			}
			catch(UserException $e){
				$this->msgErro = $e->getMessage();
				$resultado = false;
			}
			catch(\PDOException $e){
				$GLOBALS['ERRO']->setErro("consulta de mensagens de determinado usuario", $e->getMessage());
				$this->msgErro = "erro interno";
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
		private function getDadosMensagem(string $idMensagem) :array{
			$msg = new Especifica($idMensagem);
			if(!$msg->executar()) return [
				"temErro" => true,
				"erro" => $msg->erro
			];
			$retorno = [
				"temErro" => false,
				"mensagem" => $msg->mensagem,
				"temArqvs" => false
			];
			if($msg->temArqvs){
				$retorno["temArqvs"] = true;				
				$retorno["arquivos"] = $msg->arquivos;
			}
			return $retorno;
		}
		function getResposta(){
			if(!$this->getIdsMensagensDoUsuario()) return $this->msgErro;
			$resposta = [];			
			foreach($this->idMensagens as $id){								
				$msg = $this->getDadosMensagem($id[0]);
				$resposta[] = !$msg["temErro"]
					? ($msg["temArqvs"]
						? [$msg["mensagem"], $msg["arquivos"]]
						: $msg["mensagem"])
					: 0;
			}
			return $resposta;
		}
	}