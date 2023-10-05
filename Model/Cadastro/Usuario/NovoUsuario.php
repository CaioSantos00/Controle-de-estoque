<?php
	namespace App\Cadastro\Usuario;

	use App\Servicos\Conexao\ConexaoBanco as Conexao;
	use App\Servicos\Arquivos\SalvarImgPerfil\SalvarImgPerfil as SalvadorDeFoto;
	use App\IModel;

	class NovoUsuario implements Model{
		public string $idUsuario;
		private string $queryParaExecutar;
		private array $resposta;
		
		function __construct(){
			$this->queryParaExecutar ="
				insert into `Usuario`
				(`Nome`, `Email`, `Senha`, `Telefone`, `TipoConta`)
				values
				(?,?,?,?,?)
			";
		}
		function setDadosUsuario(array $dadosUsuario){
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
				if($resultado) $this->resposta =  [$resultado, $this->setFotoUsuario($this->idUsuario)];
				$this->resposta = [$resultado];
			}
		}
		private function setFotoUsuario($idUsuario) :bool{
			$image = new SalvadorDeFoto($idUsuario);
			$image->salvarImagemEnviada();
			return $image->getResposta();
		}
		function getResposta() :bool{
			return json_encode($this->resposta);
		}
	}