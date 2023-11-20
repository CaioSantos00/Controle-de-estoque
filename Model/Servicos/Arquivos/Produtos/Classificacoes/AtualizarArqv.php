<?php
	namespace App\Servicos\Arquivos\Produtos\Classificacoes;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Servicos\Arquivos\Produtos\Classificacoes\Classificacoes;
	use App\Interfaces\ServicoInterno as SI;
	
	class AtualizarArqv extends Classificacoes implements SI{
		private string $query = "select `Classificacoes` from `produtoPrimario`";
		function __construct(){
			parent::__construct();
		}
		private function getClassificacoesDoBanco() :array|bool{
			try{
				$resultado = CB::getConexao()->query($this->query)->fetchAll();				
				if(!$resultado) throw new \Exception("consulta falhou");
			}
			catch(\Exception|\PDOException $e){
				$GLOBALS['ERRO']->setErro("atualização arqv classificacoes", "na busca de todas as classificacoes do banco, {$e->getMessage()}");
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
		private function comparaClassesDoBancoComArquivo(array $classificacoesBanco) :array{
			$paraAdicionarNoArqv = [];			
			foreach($classificacoesBanco as $linhaClassificacoes){			
				$linha = json_decode($linhaClassificacoes['Classificacoes']);
				foreach($linha as $classe){
					if(!in_array($classe, $this->classificacoesSalvas)){
						if(!in_array($classe, $paraAdicionarNoArqv)) $paraAdicionarNoArqv[] = $classe;
					}
				}
			}
			return $paraAdicionarNoArqv;
		}
		private function atualizaArquivo(array $paraAdicionarNoArqv) :bool{			
			if(array_count_values($paraAdicionarNoArqv) == 0) return false;
			$this->classificacoesSalvas = array_merge($this->classificacoesSalvas, $paraAdicionarNoArqv);			
			return true;
		}
		function executar(){
			$classesNoBanco = $this->getClassificacoesDoBanco();
			if($classesNoBanco){
				$paraAlterar = $this->comparaClassesDoBancoComArquivo($classesNoBanco);
				return $this->atualizaArquivo($paraAlterar);
			}
		}
	}