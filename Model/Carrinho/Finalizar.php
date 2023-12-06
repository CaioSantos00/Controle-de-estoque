<?php
	namespace App\Carrinho;

	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Carrinho\Consultar as CCarrinho;
	use App\Interfaces\{ServicoInterno,Model};
	use App\Produtos\Variacoes\ConsultaMultipla as CMVariacoes;
	use App\Exceptions\UserException;

	class Finalizar implements Model, \Stringable{
		private Model $carrinho;
		private ServicoInterno $consultaMultipla;
		private string $idUsuario;
		private string $IdEndereco;
		private array $queries = [
			"update `usuario` set `Carrinho` = '[]' where `Id` = ?",
			"insert into `carrinhosfinalizados`(`IdDono`, `IdEndereco`, `Data`, `Conteudo`) values(?,?,?,?)",
			"update `produtosecundario` set `qtd` = ? where `Id` = ?",
			"update `produtosecundario` set `qtd` = ?, `Disponibilidade` = ? where `Id` = ?"
		];
		function __construct(string $idUsuario, string $IdEndereco){
			$this->idUsuario = $idUsuario;
			$this->IdEndereco = $IdEndereco;
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
		private function verificacaoItemUnico(\stdClass $item) :array|string{
			$this->consultaMultipla->idVariacao = $item->produto;
			$dadosItem = $this->consultaMultipla->executar();
			if(is_bool($dadosItem)) throw new \Exception("não preparou a consulta");
			return match(true){
				($dadosItem[0]["qtd"] < $item->quantidade) => "tentou pedir mais doque tem",
				($dadosItem[0]["disponibilidade"] == "0") => "produto indisponivel",
				default => ["qtd" => $dadosItem[0]["qtd"]]
			};
		}
		private function verificacaoItemAItem() :array|bool{
			try{
				$carrinho = $this->carrinho->getResposta();
				$itensErrados = [];
				$resposta = false;
				foreach($carrinho as $item){
					$verificacao = $this->verificacaoItemUnico($item);
					if(is_string($verificacao)){
						$itensErrados[] = [
							"causa" => $verificacao,
							"item" 	=> $item->produto
						];
						continue;
					}
					$novaQuantidade = (int)$verificacao["qtd"] - (int) $item->quantidade;
					if($novaQuantidade == 0){
						$this->zerarQtdEAlterarDisponibilidade($item->produto);
						continue;
					}
					$this->consomeQtdDeProdutoNoBanco((string) $novaQuantidade, $item->produto);
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
				$this->IdEndereco,
				date("d.m.y \\ g:i"),
				(string) $this->carrinho
			]);
		}
		private function esvaziaCarrinhoInicial() :bool{
			return $this->executaQuery($this->queries[0], [
				$this->idUsuario
			]);
		}
		private function consomeQtdDeProdutoNoBanco(string $qtdAtual, string $idVariacao) :bool{
			return $this->executaQuery($this->queries[2],[
				$qtdAtual,
				$idVariacao
			]);
		}
		private function zerarQtdEAlterarDisponibilidade(string $idVariacao) :bool{
			return $this->executaQuery($this->queries[3],[
				"0",
				"0",
				$idVariacao
			]);
		}
		function getResposta(){
			try{
				$retorno = true;
				$verificacao = $this->verificacaoItemAItem();
				if(is_array($verificacao))
					throw new UserException(json_encode(["mensagem" => "item errado", $verificacao]));
				if(!$verificacao)
					throw new \Exception("deu tudo errado");
				if(!$this->verificaSeCarrinhoPodeFinalizar())
					throw new UserException("carrinho vazio");
				if(!$this->insereCarrinhoNaTabelaFinalizados())
					throw new \Exception("não enviou para a tabela de finalizados");
				if(!$this->esvaziaCarrinhoInicial())
					throw new \Exception("não esvaziou o carrinho do usuario");
			}
			catch(UserException $e){
				$retorno = $e->getMessage();
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
