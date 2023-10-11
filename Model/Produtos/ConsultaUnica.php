<?php
	namespace App\Produtos;
	
	use App\Interfaces\Model;
	use App\Interfaces\Consulta;
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Servicos\Arquivos\Produtos\Imgs\ConsultaUnica as CU;
	use App\Servicos\Arquivos\Descricoes\BuscarDescricao as BD;
	
	class ConsultaUnica extends Consulta implements Model, Stringable{
		private string $idProduto;
		function __construct(string $idProduto){
			$this->idProduto = $idProduto;
		}
		private function setParametroConsultaPrincipal(){
			$id = CB::getConexao()->quote($this->idProduto);
			$this->queriesConsulta .= " where `Id` = {$id}";
		}
		function __toString(){
			return json_encode($this->getResposta());
		}
		function getResposta() :array{
			$retorno = 	[];
				$retorno[] = $this->buscarDadosPrincipaisDoBanco(new CU);
				$retorno[] = (string) new BD($this->idProduto);
			
			return $retorno;
		}
	}