<?php
	namespace App\Servicos\Arquivos\Produtos;
	
	use App\Interfaces\ServicoInterno;
	
	class Classificacoes implements ServicoInterno, Stringable{
		private array $classificacoesSalvas;
		private array $classificacoesParaSalvar;
		function __construct(array|string $classificacoes = ""){			
			$this->classificacoes = json_decode(
				file_get_contents("arqvsSecundarios/Produtos/Classificacoes.txt")
			);
			$this->classificacoesParaSalvar = is_array($classificacoes) ? $classificacoes : [];
		}
		function __toString(){
			return json_encode($this->classificacoes);
		}		
		function __destruct(){
			file_put_contents("arqvsSecundarios/Produtos/Classificacoes.txt", json_encode($this->classificacoes));
		}
		private function salvarClassificacoes(){
			$this->classificacoes = array_merge($this->classificacoesParaSalvar, $this->classificacoesSalvas);
			$this->classificacoes = array_unique($this->classificacoesSalvas);
		}
		function executar(){
			$this->salvarClassificacoes($usando);
		}
	}