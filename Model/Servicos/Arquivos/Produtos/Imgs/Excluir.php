<?php
	namespace App\Servicos\Arquivos\Produtos\Imgs;

	use App\Servicos\Arquivos\Produtos\Imgs\ConsultaUnica;
	use App\Interfaces\ServicoInterno;

	class Excluir extends ConsultaUnica implements ServicoInterno{
		private array $imagens;
		function __construct(string $idProduto, string $tipoOperacao = ""){
			$this->idProduto = $idProduto;
			switch($tipoOperacao){
				case "todasDeste";
					$this->imagens = parent::executar();
					break;
			}
		}
		function setParametros(string|array $parametros){
			if(is_array($parametros)) $this->imagens = $parametros;return;
			$tipoImg = explode("/", $parametros)[0];
			$this->imagens[$tipoImg] = $parametros;
		}
		private function excluirImagens() :bool{
			$resultados = [];
			foreach($this->imagens['Principais'] as $principais) $resultados[] = unlink("arqvsSecundarios/Produtos/Fotos/{$this->idProduto}/Principais/{$principais}");
			foreach($this->imagens['Secundarios'] as $principais){
				$diretorio = array_diff(scandir("arqvsSecundarios/Produtos/Fotos/{$this->idProduto}/Secundarias/{$principais}"), ['.','..']);
				foreach($diretorio as $img) $resultados[] = unlink("arqvsSecundarios/Produtos/Fotos/{$this->idProduto}/Secundarias/{$principais}/{$img}");
			}
			
			return !in_array(false, $resultados)
		}
		function executar() :bool{
			return $this->excluirImagens();
		}
	}