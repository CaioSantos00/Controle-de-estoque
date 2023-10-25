<?php
	namespace Controladores\Rotas\RotasUser\UserRequests;
	
	use App\Carrinho\AdicionarItem;
	use App\Carrinho\RemoverItem;
	use App\Carrinho\Consultar;
	use App\Carrinho\Finalizar;
	
	class CarrinhoRequests{
		//function __construct(){
		//	if(!isset($_POST['Submit'])) exit("Bela tentativa, hacker...");
		//	if(isset($_COOKIE['login'])) $this->logado = true;
		//}
		function adicionarItem($data){
			return (string) new AdicionarItem(
				$data['login'],
				$data['idVariacao'],
				$data['qtd']
			);
			
		}
		function removerItem($data){
			return (string) new RemoverItem(
				$data['login'],
				$data['idVariacao'],
				$data['qtd']
			);
		}
		function consultar($data){
			$carrinho =  new Consultar;
			$carrinho->executar(hex2bin($data['login']));
			return (string) $carrinho;
		}
		function finalizar($data){
			return (string) Finalizar(
				hex2bin($data['login'])
			);
		}
	}