<?php
	namespace Controladores\Rotas\RotasAdm\AdmRequests;
	
	use App\Produtos\{
		ConsultaGeral as ConsultaProdutos,
		ConsultaUnica as ConsultaProduto
	};
	use App\Usuario\ConsultarTodos as ConsultaUsuarios;
	use App\Carrinho\ConsultarFinalizados as ConsultaCarrinhosTerminados;

	class AdmRequests{
		/*function __construct(){
			if(!isset($_COOKIE['TipoConta'])) exit("sai fora, Hacker!");
			if(!isset($_POST['submit'])) exit("continua aqui? Hacker!");
		}*/		
		function consultarProdutos($data){
			echo new ConsultaProdutos;
		}
		function consultarProduto($data){
			echo new ConsultaProduto($data['id']);
		}
		function consultarUsuarios($data){
			echo new ConsultaUsuarios;
		}
		function consultarCarrinhosFinalizados($data){
			echo new ConsultaCarrinhosTerminados;
		}
	}
