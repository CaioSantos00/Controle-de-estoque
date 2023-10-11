<?php
	namespace Controladores\Rotas\RotasAdm\AdmRequests;	
	
	use App\Administracao\Produtos\Cadastro as CadastroProduto;
	use App\Administracao\Produtos\Exclusao as ExclusaoProduto;
	use App\Produtos\ConsultaGeral as ConsultaProdutos;
	use App\Produtos\ConsultaUnica as ConsultaProduto;
	
	class AdmRequests{
		function __construct(){
			if(!isset($_COOKIE['TipoConta'])) exit("sai fora, Hacker!");
			if(!isset($_POST['submit'])) exit("continua aqui? Hacker!");
		}
		function cadastrarProduto($data){
			$cadastro = new CadastroProduto(
				$_POST['nome'],
				$_POST['classificacoes'],
				$_POST['descricaoGeral']
			);
			$cadastro->setDadosSecundarios($_POST['dadosSecundarios']);
			
			$cadastro->executar();
		}
		function excluirProduto($data){
			$exclusao = new ExclusaoProduto($_POST['idProduto']);
			echo json_encode($exclusao->getResposta());
		}
		function consultarProdutos($data){
			echo new ConsultaProdutos();
		}
		function consultarProduto($data){
			echo new ConsultaProduto($data['id']);
		}
	}