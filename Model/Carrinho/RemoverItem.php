<?php
	namespace App\Carrinho;

	use App\Carrinho\Consultar as CCarrinho;
	use App\Carrinho\SalvarNovo as SNCarrinho;
	use App\Interfaces\Model;

	class RemoverItem extends CCarrinho implements \Stringable{
		public string $estadoRemocao;
		private string $idVariacao;
		private int $qtd;
		function __construct(string $idUsuario, string $idVariacao, string|int $qtd = '-1'){
			parent::executar($idUsuario);
			$this->idVariacao = $idVariacao;
			$this->qtd = (int) $qtd;
		}
		private function removeDoCarrinho() :array{
			$carrinhoReorganizado = $carrinho = parent::getResposta();
			$x = 0; $removeuAlgo = false;

			foreach($carrinho as $linha){
				if($linha->produto == $this->idVariacao){
					$carrinhoReorganizado = array_diff($carrinho, $linha);
					$this->estadoRemocao = "removeu 1 item";
					$removeuAlgo = true;
					break;
				}
			}
			
			if(!$removeuAlgo) $this->estadoRemocao = "não encontrado no carrinho";			
			return $carrinhoReorganizado;
		}
		private function decrementaDoCarrinho() :array{
			$carrinho = parent::getResposta();
			$linhasParaExcluir = []; $removeuAlgo = false;
			
			foreach($carrinho as $index => $linha){
				if($linha->produto == $this->idVariacao){
					$linha->quantidade -= ($this->qtd > $linha->quantidade) ? (int) $linha->quantidade : $this->qtd;
					if($linha->quantidade <= 0) $linhasParaExcluir[] = $index; $removeuAlgo = true;

				}
			}
			
			foreach($linhasParaExcluir as $excluir){
				unset($carrinho[$excluir]);
			}
			$this->estadoRemocao = $removeuAlgo ? "removeu 1 item" : "não encontrado no carrinho";
			return $carrinho;
		}
		private function verificaAcaoAExecutar() :string{
			if($this->qtd == -1) return "removeDoCarrinho";
			return "decrementaDoCarrinho";
		}
		private function salvarNoBanco() :bool{
			$acao = $this->verificaAcaoAExecutar();
			$carrinho = $this->$acao();
			if($this->estadoRemocao != "removeu 1 item") return false;
			$salvar = new SNCarrinho($carrinho, $this->idUsuario);
			return $salvar->executar();
		}
		function getResposta(){
			return $this->salvarNoBanco();
		}
		function __toString(){
			return json_encode($this->getResposta());
		}
	}