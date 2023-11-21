<?php
	namespace Controladores\Rotas\RotasAdm\AdmRequests;

	use App\Servicos\Arquivos\Produtos\Classificacoes\Cadastro;
	use App\Servicos\Arquivos\Produtos\Classificacoes\Edicao;
	use App\Servicos\Arquivos\Produtos\Classificacoes\Excluir;
	use App\Servicos\Arquivos\Produtos\Classificacoes\Classificacoes;
	use App\Servicos\Arquivos\Produtos\Classificacoes\AtualizarArqv;

	class ClassificacoesRequests{
		function __construct(){
			if(!isset($_COOKIE['TipoConta'])) exit("sai pra lá hacker");
		}
		function cadastrar($data){
			if(!isset($_SERVER['CONTENT_TYPE'])) exit("sai pra la hacker");
			$_POST = json_decode(trim(file_get_contents("php://input")), true);
			$cadastro = new Cadastro($_POST['nome']);
			echo $cadastro;
		}
		function edicao($data){
			if(!isset($_SERVER['CONTENT_TYPE'])) exit("sai pra la hacker");
			$_POST = json_decode(trim(file_get_contents("php://input")), true);
			$edicao = new Edicao($_POST['paraEditar'],$_POST['novoValor']);
			echo $edicao->executar();
		}
		function excluir($data){
			if(!isset($_SERVER['CONTENT_TYPE'])) exit("sai pra la hacker");
			$_POST = json_decode(trim(file_get_contents("php://input")), true);
			$exclusao = new Excluir($_POST['paraExcluir']);
			echo $exclusao->executar();
		}
		function consultar($data){
			$consulta = new Classificacoes();
			echo $consulta;
		}
		function atualizarArqv($data){
			$atualizacao = new AtualizarArqv();
			echo $atualizacao->executar();
		}
	}
