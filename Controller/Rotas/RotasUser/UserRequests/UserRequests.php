<?php
	namespace Controladores\Rotas\RotasUser\UserRequests;

	use App\Usuario\NovoUsuario as User;
	use App\Usuario\Perfil;
	use App\Usuario\Login;
	use App\Produtos\ConsultaGeral as CG;
	use App\Produtos\ConsultaUnica as CU;
	use App\Usuario\ExcluirPerfil as EP;
	
	class UserRequests{
		private bool $logado;
		function __construct(){
			if(!isset($_POST['Submit'])) exit("Bela tentativa, hacker...");
			if(isset($_COOKIE['login'])) $this->logado = true;
		}
		private function verificarExiste(string|array $dados) :bool{
			if(is_array($dados)){
				foreach($dados as $dado){
					if(!isset($dado)) return false;
				}
				return true;
			}
			if(!isset($dados)) return false;
			return true;
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
			if(!isset($_POST['Email']) or !isset($_POST['Senha'])) exit("Bela tentativa, hacker...");
			$usuario = new Login($_POST['Email'], $_POST['Senha']);
			echo $usuario->getResposta();
		}
		function perfil($data) :void{			
			echo new Perfil($_COOKIE['login']);
		}
		function excluirPerfil($data){
			if(
				!isset($_POST['idUsuario'])
					or
				$_POST['idUsuario'] != $_COOKIE['LOGIN']
			)
			   	exit("Bela tentativa, hacker...");
			$perfil = new EP($_POST['idUsuario']);
			echo $perfil->executar();
		}		
		function consultaGeral($data):void {
			echo new CG;
		}
		function consultaUnica($data) :void{
			echo new CU($data['id']);
		}
	}
