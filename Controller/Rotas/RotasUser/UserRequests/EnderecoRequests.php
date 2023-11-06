<?php
	namespace Controladores\Rotas\RotasUser\UserRequests;
	use App\Enderecos\Consultar;
	use App\Enderecos\Cadastrar;
	use App\Enderecos\Editar;
	use App\Enderecos\Excluir;	

	class EnderecoRequests{
		private string $idUsuario;
		function __construct(){
			$this->idUsuario = $_COOKIE['user'];
		}
		function cadastrar($data){
			$cadastro = new Cadastro(
				$this->idUsuario,
				$data['idEndereco'],
				$data['dadosEndereco']
			);
			echo $cadastro->getResposta();
		}
		function consultar($data){
			$consulta = new Consulta(
				$this->idUsuario	
			);
			echo $consulta->getResposta();
		}
		function excluir($data){
			$excluir = new Excluir(
				$this->idUsuario,
				$data['idsEndereco']
			);
			echo $excluir->getResposta();
		}
		function editar($data){
			$editar = new Editar(
				$this->idUsuario,
				$data['idEndereco'],
				$data['dadosEndereco']	
			);
			echo $editar->getResposta();
		}
	}
