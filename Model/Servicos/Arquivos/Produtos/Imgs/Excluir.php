<?php
	namespace App\Servicos\Arquivos\Produtos\Imgs;

	use App\Servicos\Arquivos\Produtos\Imgs\Buscar;
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
		function setParametros(array $parametros){
			$this->imagens = $parametros;
		}
		private function excluirImagens(){
			foreach($this->imagens as $imagem){
				unlink("arqvsSecundarios/Produtos/{$this->idProduto}/{$imagem}");
			}
		}
		function executar(){
			$this->excluirImagens();
		}
	}