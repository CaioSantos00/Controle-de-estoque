<?php
	namespace Controladores\Rotas\RotasUser\UserRequests;
	use App\Enderecos\Consultar;
	use App\Enderecos\Cadastrar;
	use App\Enderecos\Editar;
	use App\Enderecos\Excluir;	
    
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
		    $consulta = new Consultar(
				$this->idUsuario	
			);
			echo $consulta->getResposta();
		}
		function excluir($data){
			$excluir = new Excluir(
				$this->idUsuario,
				$_POST['idEndereco']
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
