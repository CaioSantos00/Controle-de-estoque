<?php
	namespace App\Servicos\Arquivos\Produtos\Classificacoes;
	
	use App\Servicos\Arquivos\Produtos\Classificacoes\Classificacoes;
	
	class Cadastro extends Classificacoes{
		public string $saida;
		function __construct(string $nome){
			parent::__construct();
			if(in_array($nome, $this->classificacoesSalvas)){
				$this->saida = "ja tava cadastrado";
				$GLOBALS['ERRO']->setErro("cadastro classificação", "tentou cadastrar uma classificação que já existe");
				return;
			}
			$this->classificacoesSalvas[] = $nome;
			$this->saida = "cadastrou nova";
		}
	}