<?php
	namespace Controladores\Rotas\RotasUser\UserRequests;

	use App\Cadastro\Usuario\NovoUsuario as User;
	use App\Servicos\Login\Login;

	class UserRequests{
		private bool $logado;
		function __construct(){
			if(!isset($_POST['Submit'])) exit("Bela tentativa, hacker...");
			if(isset($_COOKIE['login'])) $this->logado = true;
		}
		function cadastro($data) :void{
			$cadastro = new User();
			$dadosUsuario = [
				$_POST['Nome'],
				$_POST['Email'],
				$_POST['Senha'],
				$_POST['Telefone'],
				0
			];
			$cadastro->setDadosUsuario($dadosUsuario);
			echo $cadastro->getResposta();
		}

		function login($data) :void{
			$usuario = new Login($_POST['Email'], $_POST['Senha']);
			echo $usuario->getResposta();
		}
	}