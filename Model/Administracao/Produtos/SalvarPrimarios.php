<?php
	namespace App\Administracao\Produtos;

	use App\Servicos\Conexao\ConexaoBanco as Conn;
	use App\Interfaces\{Model,ServicoInterno};
	use App\Produtos\SalvarDados;

	class SalvarPrimarios implements Model{
		private string $idProduto;
		private array $dadosPrimarios;
		private string $descricao;
		private ServicoInterno $SalvarDescricao;
		private ServicoInterno $SalvarImagens;
		const QUERY = "Insert into `ProdutoPrimario` (`Nome`, `Classificacoes`) values (:Nome ,:Classificacoes)";
		function __construct(ServicoInterno $SalvarDescricao, ServicoInterno $SalvarImagens){
			$this->SalvarDescricao = $SalvarDescricao;
			$this->SalvarImagens = $SalvarImagens;
		}
		function setDadosParaSalvar(string $nome, string $classificacoes, string $descricao){
			$this->descricao = trim($descricao);
			$this->dadosPrimarios = [
				"Nome" => trim($nome),
				"Classificacoes" => trim($classificacoes)
			];			
		}
		private function salvarNoBanco() :bool{
			SalvarDados::$dado = $this->dadosPrimarios;
			SalvarDados::$query = self::QUERY;
			SalvarDados::Executar();
			if(!SalvarDados::$ok) return false;
			$this->idProduto = Conn::getConexao()->lastInsertId();
			return true;
		}
		private function salvarArquivos(){
			$this->SalvarDescricao->setDados($this->idProduto, $this->descricao);
			$this->SalvarImagens->setDados($this->idProduto);
			
			$this->SalvarDescricao->executar();
			$this->SalvarImagens->executar();
		}
		function getResposta(){
			try{
				if(!$this->salvarNoBanco()) return "erro interno";
				$this->salvarArquivos();
				return "ok";
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro("Cadastro Produto Primarios", $e->getMessage());
				echo "erro interno";
			}
		}
	}
