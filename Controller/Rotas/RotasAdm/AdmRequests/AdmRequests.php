<?php
	namespace Controladores\Rotas\RotasAdm\AdmRequests;

	use App\Produtos\{
		ConsultaGeral as ConsultaProdutos,
		ConsultaUnica as ConsultaProduto,
		ConsultaPrimarios,
		ConsultaCompra
	};
	use App\Usuario\ConsultarTodos as ConsultaUsuarios;
	use App\Carrinho\ConsultarFinalizados as ConsultaCarrinhosTerminados;

	class AdmRequests{
		function __construct(){
			if(!isset($_COOKIE['TipoConta'])) exit("sai fora, Hacker!");
			//if(!isset($_POST['submit'])) exit("continua aqui? Hacker!");
		}
		function consultarProdutos($data){
			echo new ConsultaProdutos;
		}
		function consultarVariacao($data){
			$busca = new ConsultaCompra($data['idVariacao']);
			echo json_encode($busca->getResposta());
		}
		function consultarProdutosPrimarios($data){
			$primarios = new ConsultaPrimarios;
			$primarios->executar();
			echo json_encode($primarios->getPrimarios());
		}
		function consultarProduto($data){
			echo new ConsultaProduto($data['idPrimario']);
		}
		function consultarUsuarios($data){
			echo new ConsultaUsuarios;
		}
		function consultarCarrinhosFinalizados($data){
			echo new ConsultaCarrinhosTerminados;
		}
	}
