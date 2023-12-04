<?php
	namespace Controladores\Rotas\RotasAdm\AdmRequests;

	use App\Administracao\Produtos\{
		Editar as EdicaoProduto,
		Exclusao as ExclusaoProduto,
		SalvarPrimarios as SalvarDadosPrimarios
	};
	use App\Servicos\Arquivos\Produtos\Imgs\Salvar as ImgProd;
	use App\Servicos\Arquivos\Produtos\Descricoes\CriarDescricao as DcsProd;
	use App\Produtos\Variacoes\{
		Salvar as 	SlvVar,
		Editar as 	EdtVar,
		Excluir as 	ExcVar
	};

	class ProdutoRequests{
		function __construct(){
			if(count($_POST) == 0) exit("erro interno");
		}
		function excluirProduto($data){
			$exclusao = new ExclusaoProduto($_POST['idProduto']);
			echo json_encode($exclusao->getResposta());
		}
		function salvarDadosPrincipais($data){
			$dados = new SalvarDadosPrimarios(new ImgProd, new DcsProd);
			$dados->setDadosParaSalvar($_POST['Nome'],$_POST['Classificacoes'],$_POST['Descricao']);
			echo $dados->getResposta();
		}
		function editarTodosDados($data){
			$dados = new EdicaoProduto($_POST['Primarios'],$_POST['Secundarios']);
			echo $dados->getResposta();
		}
		function criarDadoSecundario($data){
			$dados = new SlvVar($_POST, "fotosSecundarias");
			echo json_encode($dados->getResposta());
		}
		function editarDadoSecundario($data){
			$dados = new EdtVar($_POST['idVariacao'],$_POST);
			echo json_encode($dados->getResposta());
		}
		function excluirVariacao($data){
			$excluir = new ExcVar($_POST['idVariacao'],$_POST['idProduto']);
			echo json_encode($excluir->getResposta());
		}
	}