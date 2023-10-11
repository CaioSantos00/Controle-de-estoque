<?php
	namespace App\Carrinho;

	use App\Carrinho\Consultar as CCarrinho;
	use App\Carrinho\SalvarNovo as SNCarrinho;
	use App\Interfaces\Model;

	class RemoverItem extends CCarrinho implements Model, Stringable{
		private string $idVariacao;
		private int $qtd;
		function __construct(string $idUsuario, string $idVariacao, string|int $qtd = '-1'){
			parent::executar($idUsuario);
			$this->idVariacao = $idVariacao;
			$this->qtd = (int) $qtd;
		}
		private function removeDoCarrinho() :array{
			$carrinho = parent::getResposta();
			foreach($carrinho as $linha){
				if($linha->produto == $this->idVariacao){
					return array_diff($carrinho, $linha);
				}
			}
			return [false];
		}
		private function decrementaDoCarrinho() :array{
			$carrinho = parent::getResposta();
			foreach($carrinho as $linha){
				if($linha->produto == $this->idVariacao){
					$linha->quantidade -= $this->qtd > $linha->quantidade ? $linha->quantidade : $this->qtd;
					if($linha->quantidade <= 0) $linha->quantidade = 0;
					return $carrinho;
				}
			}
			return [false];
		}
		private function verificaAcaoAExecutar() :string{			
			if($this->qtd == -1) return "removeDoCarrinho";
			return "decrementaDoCarrinho";
		}
		private function salvarNoBanco() :bool{
			$acao = $this->verificaAcaoAExecutar()
			$carrinho = $this->$acao();
			if($carrinho[0] == false) return false;
			$salvar = new SNCarrinho($carrinho, $this->idUsuario);
			return $salvar->executar();
		}
		function getResposta() :bool{
			return $this->salvarNoBanco();
		}
		function __toString(){
			return $this->getResposta();
		}
	}