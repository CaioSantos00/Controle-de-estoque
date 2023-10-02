<?php
	namespace Cadastro\Usuario;

	use Servicos\Conexao\ConexaoBanco as Conexao;
	use Servicos\Arquivos\UploadManager as Image;

	class NovoUsuario{
		private string $idUsuario;
		private string $queryParaExecutar;
		function __construct(){
			$this->queryParaExecutar ="
				insert into `Usuario`
				(`Nome`, `Email`, `Senha`, `Telefone`, `TipoConta`)
				values
				(?,?,?,?,?)
			";
		}
		function setDadosUsuario(array $dadosUsuario) :bool{
			$resultado = false;
			try{
				$conexao = Conexao::getConexao();

				$conexao->beginTransaction();

				$queryExec = $conexao->prepare($this->queryParaExecutar);
				$queryExec = $queryExec->execute($dadosUsuario);
				$this->idUsuario = $conexao->lastInsertId();
				$conexao->commit();

				$resultado = $queryExec == 1 ? true : false;
			}
			catch(PDOException $e){
				$GLOBALS['ERRO']->setErro("Cadastro Usuario", $e->getMessage());
				if($conexao->inTransaction()) $conexao->rollBack();
				
				$resultado = false;
			}
			catch(Exception $e){
				$GLOBALS['ERRO']->setErro("Conexão", "conexão usada no cadastro de um Usuário");
				
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
		function setFotoUsuario() :bool{			
			return Image::salvarImagemDePerfilEnviada($this->idUsuario);
		}
	}