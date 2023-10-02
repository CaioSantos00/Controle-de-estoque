<?php
	namespace Controladores\Rotas\RotasUser\UserRequests;

	use App\Cadastro\Usuario\NovoUsuario;
	use App\Servicos\Login\Login;

	class UserRequests{
		function __construct(){
			if(!isset($_POST['Submit'])) exit("Bela tentativa, hacker...");
		}
		function cadastro($data){
			$cadastro = new NovoUsuario();
			$dadosUsuario = [
				$_POST['Nome'],
				$_POST['Email'],
				$_POST['Senha'],
				$_POST['Telefone'],
				0
			];
			$resultado = array(
				"dados" => $cadastro->setDadosUsuario($dadosUsuario),
				"fotos" => $cadastro->setFotoUsuario()
			);
			echo json_encode($resultado);
		}

		function login($data){

			$usuario = new Login($_POST['Email'], $_POST['Senha']);
			echo $usuario->getResposta();
		}
	}