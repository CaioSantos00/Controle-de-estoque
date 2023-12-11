<?php
	namespace App\Carrinho;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\Model;
	use App\Traits\OrganizarDadosConsulta as ODC;
	
	class ConsultarFinalizados implements Model, \Stringable{
		use ODC;
		private string $query = "select carrinhosfinalizados.Id as idCarrinho, carrinhosfinalizados.Data, usuario.Nome as nomeUsuario from carrinhosfinalizados INNER JOIN usuario on carrinhosfinalizados.IdDono = usuario.Id";
		private function consultarCarrinhos() :array{
			$retorno = [];
			if(($resultado = (CB::getConexao()->query($this->query))) === false) return $retorno;
			$this->organizar($retorno, $resultado);
			return $retorno;
		}

		function __toString(){
			return json_encode($this->getResposta());
		}
		function getResposta() :array{
			return $this->getCarrinhosComDonos($this->consultarCarrinhos());
		}
	}