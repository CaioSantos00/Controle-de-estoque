<?php
	namespace Controladores\Rotas\RotasAdm\AdmRequests;

	use App\Produtos\{
		ConsultaGeral as ConsultaProdutos,
		ConsultaUnica as ConsultaProduto,
		ConsultaPrimarios
	};
	use App\Usuario\ConsultarTodos as ConsultaUsuarios;
	use App\Carrinho\ConsultarFinalizados as ConsultaCarrinhosTerminados;

	class AdmRequests{
		function __construct(){
			if(!isset($_COOKIE['TipoConta'])) exit("sai fora, Hacker!");
			if(!isset($_POST['submit'])) exit("continua aqui? Hacker!");
		}
		function consultarProdutos($data){
			foreach((new ConsultaProdutos)->getResposta() as $prod){
				echo "<hr>";
				print_r($prod);
			};
		}
		function consultarVariacao($data){
			$busca = new CUVariacao($data['idVariacao'],[
				"ParentId","preco/peca",
				"qtd","especificacoes"
			]);
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
