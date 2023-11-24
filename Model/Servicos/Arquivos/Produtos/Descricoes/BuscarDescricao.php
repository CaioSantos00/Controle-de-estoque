<?php
	namespace App\Servicos\Arquivos\Produtos\Descricoes;

	use App\Interfaces\ServicoInterno;
	use App\Servicos\Arquivos\Produtos\Descricoes\CacheDescicoes as CDescricoes;

	class BuscarDescricao implements ServicoInterno, \Stringable{
		private string $idProduto;
		function __construct(string $idProduto){
			$this->idProduto = $idProduto;
		}
		function __toString(){
			return $this->executar();
		}
		function executar(){
			if(CDescricoes::inCache($this->idProduto)) return CDescricoes::getCache($this->idProduto);
			$descricao = file_get_contents("arqvsSecundarios/Produtos/Descricoes/{$this->idProduto}.txt");
			if(!is_string($descricao)){
				$GLOBALS['ERRO']->setErro("Descricao", "falhou na busca do arquivo da {$this->idProduto}");
				return "Erro ao buscar descrição";
			}
			CDescricoes::setCache($this->idProduto, $descricao);
			return $descricao;
		}
	}
