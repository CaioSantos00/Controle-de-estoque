<?php
	namespace App\Produtos;

	use App\Interfaces\Consulta;
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Servicos\Arquivos\Produtos\Imgs\ConsultaUnica as CU;
	use App\Servicos\Arquivos\Produtos\Descricoes\BuscarDescricao as BD;

	class ConsultaUnica extends Consulta implements \Stringable{
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
		function getResposta() :array{
			return array(
				"dadosProduto" => $this->buscarDadosPrincipaisDoBanco(new CU),
				"descricao" => (string) new BD($this->idProduto)
			);
		}
	}