<?php
	namespace App\Carrinho;

	use App\Carrinho\Consultar as CCarrinho;
	use App\Carrinho\SalvarNovo as SNCarrinho;
	use App\Interfaces\Model;

	class AdicionarItem extends CCarrinho implements Model, Stringable{
		private string $idVariacao;
		private string $qtd;
		function __construct(string $idUsuario, string $idVariacao, string $quantidade){
			parent::executar($idUsuario);
			$this->idVariacao = $idVariacao;
			$this->qtd = $qtd;
		}
		private function incrementarItemExistente(array $carrinho) :array{
			foreach($carrinho as $linha){
				if($linha->produto == $this->idVariacao){
					$linha->quantidade++;
					return $carrinho;
				}
			}
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
		private function salvarNoBanco(array $carrinho) :bool{
			$salvar = new SNCarrinho($carrinho, $this->idUsuario);
			return $salvar->executar();
		}
		function getResposta() :bool{
			return $this->salvarNoBanco($this->executarAdicao());
		}
		function __toString(){
			return $this->getResposta();
		}
	}