<?php
	namespace Controladores\Rotas\RotasAdm\AdmRequests;
	
	use App\Administracao\Produtos\{
		Exclusao as ExclusaoProduto,
		SalvarPrimarios as SalvarDadosPrimarios
	};
	
	class ProdutoRequests{
		
		function cadastrarProduto($data){
			
			/*
			$cadastro = new CadastroProduto(
				$_POST['nome'],
				$_POST['classificacoes'],
				$_POST['descricaoGeral']
			);
			$cadastro->setDadosSecundarios($_POST['dadosSecundarios']);

			echo $cadastro->executar();
			*/
		}
		function excluirProduto($data){
			$exclusao = new ExclusaoProduto(1);
			echo json_encode($exclusao->getResposta());
		}
		function salvarDadosPrincipais($data){
			$dados = new SalvarDadosPrimarios(
				$_POST['Nome'],
				$_POST['Classificacoes'],
				$_POST['Descricao']
			);
			echo $dados->getResposta();
		}
	}