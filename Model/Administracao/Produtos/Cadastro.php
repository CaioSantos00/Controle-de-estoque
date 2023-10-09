<?php
	namespace App\Administracao\Produtos;

	use App\Interfaces;
	use App\Servicos\Conexao\ConexaoBanco as Conn;
	use App\Servicos\Arquivos\Produtos\Imgs\Salvar;
	use App\Servicos\Arquivos\Produtos\Descricoes\CriarDescricao;
	use App\Servicos\Arquivos\Produtos\Classificacoes;

	class Cadastro implements Model, ServicoInterno{
		private array $dadosPrincipais;
		private array $dadosSecundarios = [];
		private array $querysInsercao;
		private string $idProduto;
		private string $descricaoGeralProduto;
		
		function __construct(string $nome, string $classificacoes, string $descricaoGeral){
			$this->dadosPrincipais = array(
				"Nome" => $nome,
				"Classificacoes" => $classificacoes
			);
			$this->descricaoGeralProduto = $descricaoGeral;
			$this->querysInsercao = [
				"Insert into `ProdutoPrimario`
				(`Nome`, `Classificacoes`)
				values
				(:Nome ,:Classificacoes)"
			,
				"Insert into `ProdutoSecundario`
				(`ParentId`, `Preco`, `Qtd`, `Disponibilidade`, `Descricao`)
				values
				(?,?,?,?,?)"
			];
		}
		private function salvarDescricaoPrincipal() :bool{
			$salvador = new CriarDescricao($this->idProduto, $this->descricaoGeralProduto);
			return $salvador->executar;
		}
		private function salvarDadosPrincipais(\PDO $conn){
			$query = $conn
				->prepare($this->querysInsercao[0])
				->execute($this->dadosPrincipais);
			$this->idProduto = $conn->lastInsertId();
		}
		private function salvarDadoSecundario(\PDO $conn, array $dado) :string{
			$conn
				->prepare($this->querysInsercao[1])
				->execute([$this->idProduto, ...$dado]);

			return Conn::getConexao()->lastInsertId();
		}
		private function salvarImagens(){
			$salvadorImgs = new Salvar($this->idProduto, $this->dadosSecudarios);
			$salvadorImgs->executar();
		}
		function setDadosSecundarios(string $jsonDadosSecundarios){			
			Conn::getConexao()->beginTransaction();
			try{
				$dadosVariacoesCruas = json_decode($jsonDadosSecundarios);
				foreach($dadosVariacoesCruas as $dado){
					$this->dadosSecundarios[] = [
						$this->salvarDadoSecundario(Conn::getConexao(), $dado['conteudos']),
						$dado['identificadorInput']
					];
				}
			}
			Conn::getConexao()->commit();
		}
		
		function getResposta(){

		}
		function executar(){
			$this->salvarDadosPrincipais(Conn::getConexao());
			$this->salvarDescricaoPrincipal();
		}
	}