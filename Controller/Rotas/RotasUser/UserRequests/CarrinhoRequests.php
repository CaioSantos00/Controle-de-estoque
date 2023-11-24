<?php
	namespace Controladores\Rotas\RotasUser\UserRequests;

	use App\Carrinho\ConsultarFinalizadosEspecificos as CFEspecifico;
	use App\Carrinho\AdicionarItem;
	use App\Carrinho\RemoverItem;
	use App\Carrinho\Consultar;
	use App\Carrinho\Finalizar;
	use App\Produtos\Variacoes\ConsultaMultipla as CUVariacoes;

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
			$carrinho = new Consultar;
			$consulta = new CUVariacoes();

			$carrinho = ($carrinho->executar(hex2bin($data['login'])))->getResposta();

			$retorno = [];
			foreach($carrinho as $item){
				$consulta->idVariacao = $item->produto;
				$retorno[] = $consulta->executar();
			}
			return json_encode($retorno);
		}
		function finalizar($data){
			return (string) Finalizar(
				$data['login']
			);
		}
		function finalizados($data){
			$ca = (new CFEspecifico(hex2bin($_COOKIE['login'])))->getResposta();
			$resul = [];
			foreach($ca as $item)
				$resul[] = $item[0];
			print_r($resul);
		}
	}
