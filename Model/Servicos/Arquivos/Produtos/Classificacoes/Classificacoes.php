<?php
	namespace App\Servicos\Arquivos\Produtos\Classificacoes;
		
	class Classificacoes implements \Stringable{
		private string $arqvClassificacoes;
		protected array $classificacoesSalvas;
		function __construct(){			
			$this->arqvClassificacoes = file_get_contents("arqvsSecundarios/Produtos/Classificacoes.txt");
			$arqv = json_decode($this->arqvClassificacoes);
			$this->classificacoesSalvas = is_array($arqv) ? $arqv : [];
		}
		function __toString(){
			return $this->arqvClassificacoes;
		}
		function __destruct(){
			file_put_contents("arqvsSecundarios/Produtos/Classificacoes.txt", json_encode($this->classificacoesSalvas));
		}		
	}