<?php
	namespace Controladores\Rotas\RotasUser\UserRequests;
	
	use App\Carrinho;
	
	class CarrinhoRequests{
		//function __construct(){
		//	if(!isset($_POST['Submit'])) exit("Bela tentativa, hacker...");
		//	if(isset($_COOKIE['login'])) $this->logado = true;
		//}
		function adicionarItem($data){
			$add = new Carrinho\AdicionarItem(
				hex2bin($data['login']),
				$data['idVariacao'],
				$data['qtd']
			);
			echo $add;
		}
		function removerItem($data){
			echo new Carrinho\RemoverItem(
				hex2bin($data['login']),
				$data['idVariacao'],
				$data['qtd']
			);
		}
		function consultar($data){
			$carrinho =  new Carrinho\Consultar;
			$carrinho->executar(hex2bin($data['login']));
			echo $carrinho;
		}
		function finalizar($data){
			echo new Carrinho\Finalizar(
				hex2bin($data['login'])
			);
		}
	}