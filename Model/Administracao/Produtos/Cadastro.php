<?php
	namespace App\Administracao\Produtos;

	use App\Interfaces\Model;
	use App\Servicos\Conexao\ConexaoBanco as Conn;
	use App\Servicos\Arquivos\Produtos\Imgs\Salvar;
	use App\Servicos\Arquivos\Produtos\Descricoes\CriarDescricao;
	use App\Servicos\Arquivos\Produtos\Classificacoes;

	class Cadastro implements Model{
		private array $dadosPrincipais;
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
		private string $idProduto;
		private string $descricaoGeralProduto;
		private string $jsonDadosSecundarios;
		
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
		private function salvarDadosPrincipais(\PDO $conn){
			$query = $conn
			        ->prepare($this->querysInsercao[0])
				    ->execute($this->dadosPrincipais);
			
			if($query) $this->idProduto = $conn->lastInsertId();			
		}
		private function salvarDadoSecundario(\PDO $conn, array $dado) :string{
		    $query = 
    			$conn
    				->prepare($this->querysInsercao[1])
    				->execute([$this->idProduto, ...$dado]);
            
			return $query ? Conn::getConexao()->lastInsertId() : "";
		}
		private function salvarImagens(){
			$salvadorImgs = new Salvar($this->idProduto, $this->dadosSecudarios);
			$salvadorImgs->executar();
		}
		private function setDadosSecundarios(string $jsonDadosSecundarios){			
			Conn::getConexao()->beginTransaction();			
			$dadosVariacoesCruas = json_decode($jsonDadosSecundarios);
			foreach($dadosVariacoesCruas as $dado){
				$this->dadosSecundarios[] = [
					$this->salvarDadoSecundario(
						Conn::getConexao(),
						$dado['conteudos']
					),
					$dado['identificadorInput']
				];
			}
			Conn::getConexao()->commit();			
		}
		
		function getResposta(){
			try{
				$this->salvarDadosPrincipais(Conn::getConexao());
				$this->salvarDescricaoPrincipal();
				$this->setDadosSecundarios($this->jsonDadosSecundarios);
				$this->salvarImagens();
			}
			catch(\PDOException $ex){
				$GLOBALS['ERRO']->setErro("Cadastro de produto", "na execução da query {$ex->getMessage()}");
				if(Conn::getConexao()->inTransaction())Conn::getConexao()->rollBack();
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro('Cadastro de produto', "na conexão do banco, {$e->getMessage()}");
				if(Conn::getConexao()->inTransaction())Conn::getConexao()->rollBack();
			}		
		}
	}