<?php
	namespace Controladores\Rotas\RotasUser\UserRequests;

	use App\Carrinho\ConsultarFinalizadosEspecificos as CFEspecifico;
	use App\Carrinho\AdicionarItem;
	use App\Carrinho\RemoverItem;
	use App\Carrinho\Consultar;
	use App\Carrinho\Finalizar;
	use App\Produtos\Variacoes\ConsultaMultipla as CUVariacoes;

	class CarrinhoRequests{
		private string $idUsuario;
		function __construct(){
			if(isset($_COOKIE['login'])){
				$this->idUsuario = @hex2bin($_COOKIE['login']) ?? "0";
				return;
			}
			exit("usuario não esta logado");
		}
		function adicionarItem($data){
			echo new AdicionarItem(
				$this->idUsuario,
				$data['idVariacao'],
				$data['qtd']
			);
		}
		function removerItem($data){
			echo new RemoverItem(
				$this->idUsuario,
				$data['idVariacao'],
				$data['qtd']
			);
		}
		function consultar($data){
			$carrinho = new Consultar;
			$consulta = new CUVariacoes();

			$carrinho->executar($this->idUsuario);
			$carrinho = $carrinho->getResposta();

			$retorno = [];
			foreach($carrinho as $item){
				$consulta->idVariacao = $item['produto'];
				$retorno[] = $consulta->executar();
			}
			echo json_encode($retorno, JSON_PRETTY_PRINT);
		}
		function finalizar($data){
			echo (string) new Finalizar(
				$this->idUsuario,
				$data['IdEndereco']
			);
		}
		function finalizados($data){
			echo json_encode(
				(new CFEspecifico($this->idUsuario))->getResposta(),
				JSON_PRETTY_PRINT
			);

		}
	}
