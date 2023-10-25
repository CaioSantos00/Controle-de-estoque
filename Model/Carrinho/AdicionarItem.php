<?php
	namespace App\Carrinho;

	use App\Carrinho\Consultar as CCarrinho;
	use App\Carrinho\SalvarNovo as SNCarrinho;
	use App\Produtos\Variacoes\ConsultaUnica as CUVariacao;
	use App\Interfaces\Model;

	class AdicionarItem extends CCarrinho implements \Stringable{
		private string $idVariacao;
		private string $qtd;
		private array $dadosVariacao;
		function __construct(string $idUsuario, string $idVariacao, string $quantidade){
			parent::executar($idUsuario);
			$this->idVariacao = $idVariacao;
			$this->qtd = $quantidade;
		}
		private function incrementarItemExistente(array $carrinho) :array{
			foreach($carrinho as $linha){
				if($linha->produto == $this->idVariacao){
					$linha->quantidade = (int) $linha->quantidade + (int) $this->qtd;
					if($linha->quantidade > (int) $this->dadosVariacao['Qtd']) throw new \Exception("tentou adicionar mais doque tem cadastrado");
					return $carrinho;
				}
			}
		}
		private function verificaVariacaoNoBanco() :string{
			$consulta = new CUVariacao($this->idVariacao, ['Qtd','Disponibilidade']);
			$this->dadosVariacao = $dadosVariacao = $consulta->executar();
			return match(true){				
				$dadosVariacao == [] => "tentou adicionar no carrinho uma variacao que não existe",
				$dadosVariacao['Disponibilidade'] != '1' =>"tentou adicionar no carrinho uma variacao indisponivel",
				(int) $dadosVariacao['Qtd'] < (int) $this->qtd => "tentou adicionar mais doque tem disponivel",
				default => "ok"
			};
		}
		private function verificaAcaoAExecutar(array $carrinho) :string{
			foreach($carrinho as $linha){
				if($linha->produto == $this->idVariacao) return "incrementarItemExistente";
			}
			return "adicionarNovoItemNoArray";
		}
		private function adicionarNovoItemNoArray(array $carrinho) :array{
			$carrinho[] = array(
				"produto" => $this->idVariacao,
				"quantidade" => (int) $this->qtd
			);
			return $carrinho;
		}
		private function executarAdicao() :array{
			$carrinho = parent::getResposta();
			$acao = $this->verificaAcaoAExecutar($carrinho);
			$carrinho = $this->$acao($carrinho);
			return $carrinho;
		}
		private function salvarNoBanco(array $carrinho) :string{			
			$salvar = new SNCarrinho($carrinho, $this->idUsuario);
			return $salvar->executar();
		}		
		function __toString(){
			try{
				$retorno = "ok";
				$resultadoVerificacaoVariacao = $this->verificaVariacaoNoBanco();
				if($resultadoVerificacaoVariacao != "ok") throw new \Exception($resultadoVerificacaoVariacao);
				$retorno = $this->salvarNoBanco($this->executarAdicao());

			}
			catch(\Exception $e){
				$retorno = $e->getMessage();
			}
			finally{
				return $retorno;
			}
		}
	}