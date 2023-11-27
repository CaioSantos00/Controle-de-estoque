<?php
	namespace App\Servicos\Arquivos\Produtos\Descricoes;

	use App\Interfaces\ServicoInterno;
	use App\Servicos\Arquivos\Produtos\Descricoes\CacheDescricoes as CDescricoes;

	class BuscarDescricao implements ServicoInterno, \Stringable{
		private string $idProduto;
		private string $file = "arqvsSecundarios/Produtos/Descricoes/";
		function __construct(string $idProduto){
			$this->idProduto = $idProduto;
			$this->file .= "{$this->idProduto}.txt";
		}
		function __toString(){
			return $this->executar();
		}
		function executar(){
			if(CDescricoes::inCache($this->idProduto)) return CDescricoes::getCache($this->idProduto);
			if(!file_exists($file)) return "descrição não encontrada";
			$descricao = file_get_contents($this->file);
			CDescricoes::setCache($this->idProduto, $descricao);
			return $descricao;
		}
	}
