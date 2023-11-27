<?php
	namespace App\Usuario;

	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\Model;
	use App\Exceptions\UserException;
	use App\Traits\ValidarDadosUsuario as VDUser;

	class EditarDados implements Model{
		use VDUser;
		private string $idUsuario;
		private array $dadosUsuario;
		private string $query = "update `usuario`
		set `Nome` = :nome, `Email` = :email, `Senha` = :senha, `Telefone` = :telefone
		where `Id` = :id";
		function __construct(string $idUsuario, array $dadosUsuario){
			$this->idUsuario = $idUsuario;
			$this->validar($dadosUsuario);
			$this->dadosUsuario = $this->valido
				? array_merge($dadosUsuario, ['id' => $this->idUsuario])
				: $this->dadosErrados;
		}
		private function enviaParaOBanco() :bool{
			try{
				$resultado = true;
				$query = CB::getConexao()->prepare($this->query);
				$query->execute();
				$resultado = $query->rowCount() > 0
				 ? true
				 : false;
			}catch (\Exception $e) {
				$GLOBALS['ERRO']->setErro("edição dados usuário", $e->getMessage());
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
		function getResposta(){
			return $this->valido
				? $this->enviaParaOBanco()
				: $this->dadosUsuario;
		}
	}
