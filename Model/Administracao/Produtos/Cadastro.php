<?php
	namespace App\Administracao\Produtos;

	use App\Interfaces\Model;
	use App\Servicos\Conexao\ConexaoBanco as Conn;
	use App\Produtos\SalvarDados;
	use App\Servicos\Arquivos\Produtos\Imgs\Salvar;
	use App\Servicos\Arquivos\Produtos\Descricoes\CriarDescricao;
	use App\Servicos\Arquivos\Produtos\Classificacoes;

	class Cadastro implements Model{
		private array $dadosPrincipais;
		private string $idProduto;
		private string $descricaoGeralProduto;
		private string $jsonDadosSecundarios;
		private array $dadosSecundarios = [];
		private array $querysInsercao= [
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

		function __construct(string $nome, string $classificacoes, string $descricaoGeral, string $jsonDadosSecundarios){
			$this->descricaoGeralProduto = $descricaoGeral;
			$this->jsonDadosSecundarios = $jsonDadosSecundarios;

			$this->dadosPrincipais = array(
				"Nome" => $nome,
				"Classificacoes" => $classificacoes
			);
		}
		private function salvarDescricaoPrincipal() :bool{
			$salvador = new CriarDescricao($this->idProduto, $this->descricaoGeralProduto);
			return $salvador->executar;
		}
		private function salvarDadosPrincipais(){
			SalvarDados::$dado = $this->dadosPrincipais;
			SalvarDados::$query = $this->querysInsercao[0];
			SalvarDados::Executar();
			$this->idProduto = SalvarDados::$ok
				? (Conn::getConexao())->lastInsertId()
				: "0";
		}
		private function salvarDadoSecundario(array $dado) :string{
			SalvarDados::$dado = [$this->idProduto, ...$dado];
			SalvarDados::$query = $this->querysInsercao[1];
			SalvarDados::Executar();
			return SalvarDados::$ok
				? (Conn::getConexao())->lastInsertId()
				: "";
		}
		private function salvarImagens(){
			$salvadorImgs = new Salvar($this->idProduto, $this->dadosSecundarios);
			$salvadorImgs->executar();
		}
		private function salvarDadosSecundarios(string $jsonDadosSecundarios){
			$dadosVariacoesCruas = json_decode($jsonDadosSecundarios);
			foreach($dadosVariacoesCruas as $dado){
				$this->dadosSecundarios[] = [
					$this->salvarDadoSecundario($dado['conteudos']),
					$dado['identificadorInput']
				];
			}
		}

		function getResposta(){
			try{
				$resposta = "ok";
				Conn::getConexao()->beginTransaction();
					$this->salvarDadosPrincipais();
					$this->salvarDescricaoPrincipal();
					$this->salvarDadosSecundarios($this->jsonDadosSecundarios);
					$this->salvarImagens();
				Conn::getConexao()->commit();
			}
			catch(\PDOException $ex){
				$GLOBALS['ERRO']->setErro("Cadastro de produto", "na execução da query {$ex->getMessage()}");
				Conn::voltaTudo();
				$resposta = "não";
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro('Cadastro de produto', "na conexão do banco, {$e->getMessage()}");
				Conn::voltaTudo();
				$resposta = "não";
			}
			finally{
				return $resposta;
			}
		}
	}
