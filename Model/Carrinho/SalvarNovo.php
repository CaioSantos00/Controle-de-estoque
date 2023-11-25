<?php
	namespace App\Carrinho;

	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\ServicoInterno;

	class SalvarNovo implements ServicoInterno{
		private string $carrinhoParaSalvar;
		private string $idUsuario;
		private string $query = "update `Usuario` set `Carrinho` = ? where `Id` = ?";
		function __construct(array $carrinhoParaSalvar, int|string $idUsuario){
			$this->carrinhoParaSalvar = json_encode($carrinhoParaSalvar);			
			$this->idUsuario = (string) $idUsuario;
		}
		private function salvarNoBanco() :bool{
			try{
				CB::getConexao()->beginTransaction();
					$resultado = CB::getConexao()->prepare($this->query)->execute([$this->carrinhoParaSalvar, $this->idUsuario]);
				CB::getConexao()->commit();				
				switch(true){
					case $resultado === false;
						throw new \Exception("não ocorreu a query");
						break;
					case $resultado === 0;
						throw new \Exception("Id de usuário não encontrado");
						break;
					default;
						$resultado = true;
				}
			}
			catch(\Exception|\PDOException $e){
				$GLOBALS['ERRO']->setErro("Carrinho", "no salvamento de carrinho, {$e->getMessage()}");
				CB::voltaTudo();
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
		function executar(){
			return $this->salvarNoBanco();
		}
	}