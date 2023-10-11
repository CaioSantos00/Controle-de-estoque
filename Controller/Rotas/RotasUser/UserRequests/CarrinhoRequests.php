<?php
	namespace Controladores\Rotas\RotasUser\UserRequests;
	
	use App\Carrinho;
	
	class CarrinhoRequests{
		function __construct(){
			if(!isset($_POST['Submit'])) exit("Bela tentativa, hacker...");
			if(isset($_COOKIE['login'])) $this->logado = true;
		}
		function adicionarItem($data){
			$add = new AdicionarItem(
				hex2bin($_COOKIE['login']),
				$data['idVariacao'],
				$data['qtd']
			);
			echo $add;
		}
		function removerItem($data){
			echo new RemoverItem(
				hex2bin($_COOKIE['login']),
				$data['idVariacao'],
				$data['qtd']
			);
		}
		function consultar($data){
			echo new Consultar(hex2bin($_COOKIE['login']));	
		}
		function finalizar($data){
			echo new Finalizar(
				hex2bin($_COOKIE['login'])
			);
		}
	}