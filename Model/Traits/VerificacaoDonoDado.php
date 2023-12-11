<?php
	namespace App\Traits;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	
	trait VerificacaoDonoDado{
		private \stdClass $parametros;
		private function setParametrosVerificacao(string $dadoVerificar,  bool|string $queryVerificacao = false){
			if(empty($this->parametros))
				$this->parametros = new \stdClass;
			$this->parametros->verificar = $dadoVerificar;
			if($queryVerificacao)
				$this->parametros->queryParaVerificacao = $queryVerificacao;
		}
		private function eDele() :bool{
			try{
				$query = CB::getConexao()->prepare($this->parametros->queryParaVerificacao);
				$query->execute([$this->parametros->verificar]);
				return $query->fetchAll();
			}
		}
	}