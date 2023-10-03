<?php
	namespace App\Cadastro\Usuario;

	use App\Servicos\Conexao\ConexaoBanco as Conexao;
	use App\Servicos\Arquivos\UploadsManager as Image;

	class NovoUsuario{
		public string $idUsuario;
		private string $queryParaExecutar;
		function __construct(){
			$this->queryParaExecutar ="
				insert into `Usuario`
				(`Nome`, `Email`, `Senha`, `Telefone`, `TipoConta`)
				values
				(?,?,?,?,?)
			";
		}
		function setDadosUsuario(array $dadosUsuario) :array{						
			try{
				$resultado = true;
				$conexao = Conexao::getConexao(); //Conecta
				$conexao->beginTransaction();
					$queryExec = $conexao->prepare($this->queryParaExecutar);
					$queryExec = $queryExec->execute($dadosUsuario);
					$this->idUsuario = $conexao->lastInsertId();
				$conexao->commit();				
			}			
			catch(\PDOException $e){
				if($conexao->inTransaction()) $conexao->rollBack();
				$GLOBALS['ERRO']->setErro("Cadastro Usuario", $e->getMessage());				
				$resultado = false;
			}
			catch(\Exception $e){
				if($conexao->inTransaction()) $conexao->rollBack();
				$GLOBALS['ERRO']->setErro("Conexão", "conexão usada no cadastro de um Usuário");
				$resultado = false;
			}
			finally{
				if($resultado) return [$resultado, $this->setFotoUsuario($this->idUsuario)];
				return [$resultado];
			}
		}
		private function setFotoUsuario($idUsuario) :bool{
			return Image::salvarImagemDePerfilEnviada($idUsuario);
		}
	}