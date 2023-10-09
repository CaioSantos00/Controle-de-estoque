<?php
	namespace App\Administracao\Produtos;
	
	use App\Interfaces\Model;
	use App\Servicos\Conexao\ConexaoBanco as CB;
	
	class Exclusao implements Model{
		private string $idProduto;
		function __construct(string $idProduto){
			$this->idProduto = $idProduto;
		}
		function getResposta(){
			
		}
	}
	