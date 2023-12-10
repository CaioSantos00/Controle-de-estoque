<?php
	namespace App\Produtos;

	use App\Interfaces\{Consulta, Model};
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Servicos\Arquivos\Produtos\Imgs\ConsultaUnica as CU;	
	
	class ConsultaUnica extends Consulta implements \Stringable, Model{
		private string $idProduto;
		function __construct(string $idProduto){
			$this->idProduto = $idProduto;
			$this->setParametroConsultaPrincipal();
		}
		function setParametroConsultaPrincipal(){
			$id = CB::getConexao()->quote($this->idProduto);
			$this->queriesConsulta[0] .= " where `Id` = {$id}";
		}
		function __toString(){
			return json_encode($this->getResposta());
		}
		function getResposta(){
			return $this->buscarDadosPrincipaisDoBanco(new CU);
		}
	}