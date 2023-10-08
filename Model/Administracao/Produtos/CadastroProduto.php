<?php
	namespace App\Administracao\Produtos;

	use App\Interfaces;
	use App\Servicos\Conexao\ConexaoBanco as Conn;
	use App\Servicos\Arquivos\Produtos\Imgs\SalvarImgsProdutos;
	use App\Servicos\Arquivos\Produtos\Descricoes\CriarDescricao;
	use App\Servicos\Arquivos\Produtos\Classificacoes;

	class CadastroProduto implements Model, ServicoInterno{
		private array $dadosPrincipais;
		private array $dadosSecundarios = [];
		private array $querysInsercao;
		private string $idProduto;
		private string $descricaoGeralProduto;
		
		function __construct(string $nome, array $classificacoes, string $descricaoGeral){
			$this->dadosPrincipais = array(
				"Nome" => $nome,
				"Classificacoes" => new Classificacoes($classificacoes)
			);
			$this->descricaoGeralProduto = $descricaoGeral
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
		private function salvarClassificacoes(){
			$this->dadosPrincipais["Classificacoes"]->executar();
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

			return (Conn::getConexao())->lastInsertId();
		}
		private function salvarImagens(){
			$salvadorImgs = new SalvarImgsProdutos($this->idProduto, $this->dadosSecudarios);
			$salvadorImgs->executar();
		}
		function setDadosSecundarios(string $jsonDadosSecundarios){
			$dadosVariacoesCruas = json_decode($jsonDadosSecundarios);
			foreach($dadosVariacoesCruas as $dado){
				$this->dadosSecundarios[] = [
					$this->salvarDadoSecundario(Conn::getConexao(), $dado['conteudos']),
					$dado['identificadorInput']
				];
			}
		}
		
		function getResposta(){

		}
		function executar(){
			$this->salvarClassificacoes();
			$this->salvarDadosPrincipais(Conn::getConexao());
			$this->salvarDescricaoPrincipal();
		}
	}