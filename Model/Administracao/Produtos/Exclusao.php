<?php
	namespace App\Administracao\Produtos;

	use App\Interfaces\Model;
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Exceptions\UserException;
	use App\Servicos\Arquivos\Produtos\Imgs\Excluir;
	use App\Servicos\Produtos\Descricoes\ExcluirDescricao;

	class Exclusao implements Model{
		private string $idProduto;
		private array $queries = [
			"delete from `produtosecundario` where `ParentId` = :Id",
			"delete from `produtoprimario` where `Id` = :Id"
		];
		function __construct(string $idProduto){
			$this->idProduto = $idProduto;
		}
		private function excluirImgs() :bool{
			$excluir = new Excluir($this->idProduto, "todasDeste");
			return $excluir->executar();
		}
		private function excluirDescricao() :bool{
			$excluir = new ExcluirDescricao($this->idProduto);
			return $excluir->executar();
		}
		private function excluirNoBanco(string $query) :array{
			try{
				$resultado = [false];
					$querie = CB::getConexao()->prepare($query);
					$resultado = ($querie->execute(["Id" => $this->idProduto]))
						 ? [true, $querie->rowCount()]
						 : [false];
			}
			catch(\Exception|\PDOException $e){
				$GLOBALS['ERRO']->setErro('Exclusao produto', $e->getMessage());
				$resultado = [false];
			}
			finally{
				return $resultado;
			}
		}
		private function verificaExclusaoNoBanco() :array{
			try{
				CB::getConexao()->beginTransaction();
					$resultado = ["status" => "iniciou"];
					$secundario = $this->excluirNoBanco($this->queries[0]);
						if(!$secundario[0]) throw new \Exception("falha nos secundários");
					$resultado = ["secundários" => $secundario[1]];
					$primarios = $this->excluirNoBanco($this->queries[1]);
						if(!$primarios[0]) throw new \Exception("falha nos primarios");
						if($primarios[1] != 1) throw new \Exception("não excluiu os primarios");
					$resultado["primários"] = $primarios[1];
					$resultado["status"] = "terminou";
				CB::getConexao()->commit();
			}
			catch(\Exception|\PDOException $e){
				CB::voltaTudo();
				$resultado["status"] = "falha";
				$resultado["erro"] = $e->getMessage();
			}
			finally{
				return $resultado;
			}
		}
		function getResposta(){
			$resposta = $this->verificaExclusaoNoBanco();
			return $resposta["status"] == "terminou"
				? $this->excluirImgs()
				 	? $this->excluirDescricao()
						? true
						: "não foi a descrição"
					: "não foi as imagens nem a descrição"
				: "não foi nada";				
		}
	}
