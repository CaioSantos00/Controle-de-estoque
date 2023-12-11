<?php
	namespace App\Carrinho;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\Model;
	
	class ConsultarFinalizados implements Model, \Stringable{
		private string $query = "select carrinhosfinalizados.Id as idCarrinho, carrinhosfinalizados.Data, usuario.Nome as nomeUsuario from carrinhosfinalizados INNER JOIN usuario on carrinhosfinalizados.IdDono = usuario.Id";
		private function consultarCarrinhos() :array{			
			return (($retorno = CB::getConexao()->query($this->query)) === false)
				? []
				: $retorno->fetchAll();
		}
		private function organizaCarrinhos(array $carrinhos) :array{
			$resul = [];
			foreach($carrinhos as $carrinho)
				foreach($carrinho as $chav => $item)
					if(!is_string($chav)) continue;
						$resul[] = $
		}
		function __toString(){
			return json_encode($this->getResposta());
		}
		function getResposta() :array{
			return $this->getCarrinhosComDonos($this->consultarCarrinhos());
		}
	}