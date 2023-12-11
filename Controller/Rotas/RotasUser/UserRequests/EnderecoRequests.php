<?php
	namespace Controladores\Rotas\RotasUser\UserRequests;
	
	use App\Enderecos\{	
		Consultar,
		Cadastrar,
		Editar,
		Excluir	
	};

	class EnderecoRequests{
		private string $idUsuario;
		function __construct(){
			$this->idUsuario = @hex2bin($_COOKIE['login']);
		}
		function cadastrar($data){
		    $cadastro = new Cadastrar(
				$this->idUsuario,
				$_POST['nomeEndereco'],
				$_POST['dadosEndereco']
			);
			echo $cadastro->getResposta();
		}
		function consultar($data){
		    $consulta = new Consultar;
			$consulta->setNovaConsulta($this->idUsuario);		
			echo json_encode($consulta->getResposta());
		}
		function consultarEsse($data){
			$consulta = new Consultar;
			$consulta->setNovaConsulta($data['id'],"Id");
			echo json_encode($consulta->getResposta());
		}
		function excluir($data){
			$excluir = new Excluir(
				$this->idUsuario,
				json_decode($_POST['idsEnderecos'],true)
			);
			echo $excluir->getResposta();
		}
		function editar($data){
			$editar = new Editar(
				$this->idUsuario,
				$_POST['idEndereco'],
				$_POST['dadosEndereco']
			);
			echo $editar->getResposta();
		}
	}
