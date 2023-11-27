<?php
	namespace App\Usuario;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\Model;
	use App\Exceptions\UserException;
	
	class EditarDados implements Model{
		private string $idUsuario;
		private string $query = "update `usuario`
		set `Nome` = :nome, `Email` = :email, `Senha` = :senha, `Telefone` = :telefone
		where `Id` = :id";
		function __construct(string $idUsuario, array $dadosUsuario){
			$this->idUsuario = $idUsuario;
		}
		private function validaDadosRecebidos(){
			
		}
		function getResposta(){
			
		}
	}