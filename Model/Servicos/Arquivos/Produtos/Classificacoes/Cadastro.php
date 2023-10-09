<?php
	namespace App\Servicos\Arquivos\Produtos\Classificacoes;
	
	use App\Servicos\Arquivos\Produtos\Classificacoes\Classificacoes;
	use App\Interfaces\ServicoInterno;
	
	class Cadastro extends Classificacoes{
		function __construct(string $nome){
			parent::__construct();
			if(!in_array($nome, $this->classificacoesSalvas)) $this->classificacoesSalvas[] = $nome;
		}
	}