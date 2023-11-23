<?php
	namespace Controladores\Rotas\RotasUser\UserRequests;

	use App\Usuario\NovoUsuario as User;
	use App\Usuario\Perfil;
	use App\Usuario\Login;
	use App\Produtos\ConsultaGeral as CG;
	use App\Produtos\ConsultaUnica as CU;
	use App\Usuario\ExcluirPerfil as EP;

	class UserRequests{
		function __construct(){
			if(!isset($_POST['Submit'])) exit("Bela tentativa, hacker...");
			if(count($_POST) > 0) array_map('trim',$_POST);
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
			if(!$this->verificarExiste([$_POST['Nome'],$_POST['Email'],$_POST['Telefone'],$_POST['Senha']])) exit("Bela tentativa, hacker...");
			$senha = password_hash($_POST['Senha'], PASSWORD_DEFAULT);
			if(is_bool($senha)) exit("erro interno");
			$cadastro = new User;
			$dadosUsuario = [$_POST['Nome'],$senha,$_POST['Email'],$_POST['Telefone'],0];
			$cadastro->setDadosUsuario($dadosUsuario);
			echo $cadastro->getResposta();
		}
		function login($data) :void{
			if(!$this->verificarExiste([$_POST['Email'],$_POST['Senha']])) exit("Bela tentativa, hacker...");
			$usuario = new Login($_POST['Email'], $_POST['Senha']);
			echo $usuario->getResposta();
		}
		function perfil($data) :void{
			if(!$this->verificarExiste($_COOKIE['login'])) exit("não esta logado");
			echo new Perfil($_COOKIE['login']);
		}
		function excluirPerfil($data){
			if($this->verificarExiste([$_POST['idUsuario'],$_COOKIE['login']]) and $_POST['idUsuario'] == hex2bin($_COOKIE['login'])){
				$perfil = new EP($_POST['idUsuario']);
				echo $perfil->executar();
				return;
			}
			exit("Bela tentativa, hacker...");
		}
		function consultaGeral($data):void {
			echo new CG;
		}
		function consultaUnica($data) :void{
			echo new CU($data['id']);
		}
	}
