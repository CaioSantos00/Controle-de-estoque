<?php
	namespace App\Servicos\Arquivos\Produtos\Imgs;

	use App\Servicos\Arquivos\Produtos\Imgs\ConsultaUnica;
	use App\Interfaces\ServicoInterno;

	class Excluir extends ConsultaUnica implements ServicoInterno{
		private array $imagens;
		private string $idProduto;
		function __construct(string $idProduto, string $tipoOperacao = ""){
			$this->idProduto = $idProduto;
			switch($tipoOperacao){
				case "todasDeste";
					$this->imagens = parent::executar($idProduto);
					break;				
			}
		}
		function setParametros(string|array $parametros){
			if(is_array($parametros)) $this->imagens = $parametros;return;
			$this->imagens[] = $parametros;
		}
		private function excluirImagens() :bool{
			$resultados = [];
			//foreach($this->imagens as $imagem){
			//	$resultados[] = unlink("arqvsSecundarios/Produtos/{$this->idProduto}/{$imagem}");
			//}
			//foreach($resultados as $resultado) if(!$resultado) return false;
			//return true;
		}
		function executar() :bool{
			return $this->excluirImagens();
		}
	}