<?php
	namespace App\Carrinho;

	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Carrinho\Consultar as CCarrinho;
	use App\Interfaces\ServicoInterno as ServicoInterno;
	use App\Produtos\Variacoes\ConsultaMultipla as CMVariacoes;
	use App\Interfaces\Model;


	class Finalizar implements Model, \Stringable{
		private Model $carrinho;
		private ServicoInterno $consultaMultipla;
		private string $idUsuario;
		private array $queries = [
			"update `usuario` set `Carrinho` = '[]' where `Id` = ?",
			"insert into `carrinhosfinalizados`(`IdDono`, `Data`, `Conteudo`) values(?,?,?)"
		];
		function __construct(string $idUsuario){
			$this->idUsuario = $idUsuario;
			$this->consultaMultipla = new CMVariacoes(false, true);
			
			$this->carrinho = new CCarrinho;
			$this->carrinho->executar($idUsuario);
		}
		private function executaQuery(string $query, array $parametros) :bool{
			try{
				CB::getConexao()->beginTransaction();
					$resultado =
					CB::getConexao()
						->prepare($query)
						->execute($parametros);
				CB::getConexao()->commit();

				if($resultado == 0) throw new \Exception("Usuario não encontrado");
			}
			catch(\Exception|\PDOException $e){
				$GLOBALS['ERRO']->setErro("Finalização de carrinho", "na execução da query: {$query}; {$e->getMessage()}");
				CB::voltaTudo();
				$resultado = false;
			}
			finally{
				if($resultado === false) return $resultado;
				return true;
			}
		}
		private function verificacaoItemUnico(\stdClass $item) :bool|string{
			$this->consultaMultipla->idVariacao = $item->produto;
			$dadosItem = $this->consultaMultipla->executar();
			$GLOBALS['ERRO']->setErro("finalizar", json_encode($item));
			if(is_bool($dadosItem)) throw new \Exception("não preparou a consulta");
			return match(true){
				($dadosItem[0]["qtd"] < $item->quantidade) => "tentou pedir mais doque tem",
				($dadosItem[0]["disponibilidade"] == "0") => "produto indisponivel",
				default => true
			};
		}
		private function verificacaoItemAItem() :array|bool{
			try{
				$carrinho = $this->carrinho->getResposta();
				$itensErrados = [];$resposta = false;
				foreach($carrinho as $item){
					$verificacao = $this->verificacaoItemUnico($item);
					if(is_string($verificacao))
						$itensErrados[] = [
							"causa" => $verificacao,
							"item" 	=> $item->produto
						];
				}
				$resposta = (count($itensErrados) > 0) ? $itensErrados : true;
			}
			catch(\PDOException $e){
				$GLOBALS['ERRO']->setErro("finalizacao de carrinho", "na execução da query: {$e->getMessage()}");
				CB::voltaTudo();
				$resposta = false;
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro("finalizacao de carrinho", "na finalização: {$e->getMessage()}");
				$resposta = false;
			}
			finally{
				return $resposta;
			}
		}
		private function verificaSeCarrinhoPodeFinalizar() :bool{			
			if((string) $this->carrinho == "[]") return false;
			return true;
		}
		private function insereCarrinhoNaTabelaFinalizados() :bool{
			return $this->executaQuery($this->queries[1], [
				$this->idUsuario,
				date("d.m.y \\ g:i"),
				(string) $this->carrinho
			]);
		}
		private function esvaziaCarrinhoInicial() :bool{
			return $this->executaQuery($this->queries[0], [
				$this->idUsuario
			]);
		}
		function getResposta() :bool{
			try{
				$verificacao = $this->verificacaoItemAItem();
				$retorno = match(true){
					(is_array($verificacao)) => "algum item deu errado",
					(!$verificacao)	=> "deu tudo errado",
					(!$this->verificaSeCarrinhoPodeFinalizar()) => "carrinho vazio",
					(!$this->insereCarrinhoNaTabelaFinalizados())=> "não enviou para a tabela de finalizados",
					(!$this->esvaziaCarrinhoInicial()) => "não esvaziou o carrinho do usuario",
					default => true
				};
				if(is_string($retorno)) throw new \Exception($retorno);
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro("finalização de carrinho", $e->getMessage(). "no {$this->idUsuario}");
				$retorno = false;
			}
			finally{
				return $retorno;
			}
		}
		function __toString(){
			return $this->getResposta();
		}
	}
