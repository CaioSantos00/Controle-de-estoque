<?php
	namespace Controladores\Rotas\RotasUser\UserRequests;
	
	use App\Cadastro\Usuario\NovoUsuario;
	use App\Servicos\Login\Login;
	
	class UserRequests{
		public function cadastro($data){			
			if(!isset($_POST['Submit'])) return;
			
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
			
		public function login($data){
			if(!isset($_POST['Submit'])) return;
			$usuario = new Login($_POST['Email'], $_POST['Senha']);
			echo $usuario->getResposta();
		}
	}