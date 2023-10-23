<?php
	namespace Controladores\Rotas\RotasAdm\AdmRequests;
	
	use App\Servicos\Arquivos\Produtos\Classificacoes\Cadastro;
	use App\Servicos\Arquivos\Produtos\Classificacoes\Edicao;
	use App\Servicos\Arquivos\Produtos\Classificacoes\Excluir;
	use App\Servicos\Arquivos\Produtos\Classificacoes\Classificacoes;
	use App\Servicos\Arquivos\Produtos\Classificacoes\AtualizarArqv;

	class ClassificacoesRequests{
		function __construct(){
			//if(!isset($_COOKIE['TipoConta'])) exit("sai pra lá hacker");
		}
		function cadastrar($data){
			$cadastro = new Cadastro($data['nome']);
			return $cadastro;
		}
		function edicao($data){
			$edicao = new Edicao($data['paraEditar'],$data['novoValor']);
			return $edicao->executar();
		}
		function excluir($data){
			$exclusao = new Excluir($data['paraExcluir']);
			return $exclusao->executar();
		}
		function consultar($data){
			$consulta = new Classificacoes();
			return $consulta;
		}
		function atualizarArqv($data){
			$atualizacao = new AtualizarArqv();
			return $atualizacao->executar();
		}
	}