<?php
	namespace Controladores\Rotas\RotasUser\UserRequests;

	use App\Usuario\{
		NovoUsuario as User,
		Perfil,
		Login,
		ExcluirPerfil as EP
	};
	use App\Produtos\{
		ConsultaGeral as CG,
		ConsultaUnica as CU
	};	
	use App\Servicos\Arquivos\PerfilUsuario\Salvar as FotoUser;

	class UserRequests{
		function __construct(){
			if(count($_POST) > 0){
				if(!isset($_POST['Submit'])) exit("Bela tentativa, hacker...");
				if(count($_POST) > 0) array_map('trim',$_POST);
			}
		}
		private function verificarExiste(string|array $dados) :bool{
			if(is_array($dados)){
				foreach($dados as $dado) if(!isset($dado)) return false;
				return true;
			}
			if(!isset($dados)) return false;
			return true;
		}
		function cadastro($data) :void{
			if(!$this->verificarExiste([$_POST['Nome'],$_POST['Email'],$_POST['Telefone'],$_POST['Senha']])) exit("Bela tentativa, hacker...");			
			if(is_bool(
				$senha = password_hash($_POST['Senha'], PASSWORD_DEFAULT))
			) exit("erro interno");
			$cadastro = new User(new FotoUser);
			$dadosUsuario = [
				$_POST['Nome'],
				$senha,
				$_POST['Email'],
				$_POST['Telefone'],
				0
			];
			$cadastro->setDadosUsuario($dadosUsuario);
			$cadastro->executar();
			exit(json_encode($cadastro->getResposta()));			
		}
		function login($data) :void{
			if(!$this->verificarExiste([$_POST['Email'],$_POST['Senha']])) exit("Bela tentativa, hacker...");
			$usuario = new Login($_POST['Email'], $_POST['Senha']);
			echo $usuario->getResposta();
		}
		function perfil($data) :void{
			if(!$this->verificarExiste($_COOKIE['login'])) exit("não esta logado");
			$dados = (new Perfil($_COOKIE['login']))->getResposta();
			if(is_string($dados[1])) exit("não encontrado");
			$retorno = [$dados[0],[]];
			for($x = 0; $x != 5; $x++){
				$retorno[1][] = $dados[1][0][$x];
			}
			echo json_encode($retorno);
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
