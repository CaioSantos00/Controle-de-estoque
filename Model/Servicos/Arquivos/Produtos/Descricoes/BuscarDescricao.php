<?php	
	namespace App\Servicos\Arquivos\DescricoesProdutos;
	
	use App\Interfaces\ServicoInterno;
	class BuscarDescricao implements ServicoInterno{
		private string $idProduto;
		function __construct(string $idProduto){
			$this->idProduto = $idProduto;
		}
		function executar() :string{
			$descricao = file_get_contents("arqvsSecundarios/Produtos/Descricoes/{$this->idProduto}.txt");
			if(!is_string($descricao)){
				$GLOBALS['ERRO']->setErro("Descricao", "falhou na busca do arquivo da {$this->idProduto}");
				return "Erro ao buscar descrição";
			}
			return $descricao;			
		}
	}