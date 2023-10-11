<?php
	namespace App\Carrinho;

	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Carrinho\Consultar as CCarrinho;
	use App\Interfaces\Model;

	class Finalizar implements Model, Stringable{
		private string $carrinho;
		private string $idUsuario;
		private array $queries = [
			"update `usuario` set `Carrinho` = '[]' where `Id` = ?",
			"insert into `carrinhosfinalizados`(`IdDono`, `Data`, `Conteudo`) values(?,?,?)"
		];
		function __construct(string $idUsuario){
			$this->carrinho = (string) new CCarrinho($idUsuario);
			$this->idUsuario = $idUsuario;
		}
		private function executaQuery(string $query, array $parametros) :bool{
			try{
				CB::getConexao()->beginTransaction();
					$resultado =
					CB::getConexao()
						->prepare($query)
						->execute($parametros);
				CB::getConexao()->commit();

				if($resultado == 0) throw new Exception("Usuario não encontrado");
			}
			catch(\Exception|\PDOException $e){
				$GLOBALS['ERRO']->setErro("Finalização de carrinho", "na execução da query: {$query}; {$e->getMessage()}");
				if(CB::getConexao()->inTransaction()) CB::getConexao()->rollBack();
				$resultado = false;
			}
			finally{
				if($resultado === false) return $resultado;
				return true;
			}
		}
		private function insereCarrinhoNaTabelaFinalizados() :bool{
			return $this->executaQuery($this->queries[1], [
				$this->idUsuario,
				date("d.m.y \\ g:i"),
				$this->carrinho
			]);
		}
		private function esvaziaCarrinhoInicial() :bool{
			return $this->executaQuery($this->queries[0], [
				$this->idUsuario
			]);
		}
		function getResposta() :bool{
			if($this->insereCarrinhoNaTabelaFinalizados() and $this->esvaziaCarrinhoInicial()) return true;
			return false;
		}
		function __toString(){
			return $this->getResposta();
		}
	}