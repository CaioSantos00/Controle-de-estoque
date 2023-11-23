<?php
	namespace App\Servicos\Arquivos\Produtos\Classificacoes;

	use App\Interfaces\ServicoInterno;
	use App\Servicos\Arquivos\Produtos\Classificacoes\Classificacoes;
	use App\Servicos\Conexao\ConexaoBanco as CB;

	class Edicao extends Classificacoes implements ServicoInterno{
		private array $querys = [
			"select `Id`,`Classificacoes` from `produtoPrimario`",
			"update `produtoprimario` set `Classificacoes` = ? where `Id` = ?"
		];
		private array $dadosParaExecutar;
		function __construct(string $paraEditar, string $novoValor){
			parent::__construct();			
			$this->dadosParaExecutar = array(
				"novo" => $novoValor,
				"velho" => $paraEditar
			);
		}
		private function getAllClassificacoesNoBanco() :\PDOStatement|bool{
			try{
				$select = CB::getConexao()
					->query($this->querys[0]);
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro("Edicao de classificação", "Na conexao da consulta: {$e->getMessage()}");
				$select = false;
			}
			catch(\PDOException $e){
				$GLOBALS['ERRO']->setErro("Edicao de classificação", "Na execução da query de consulta: {$e->getMessage()}");
				$select = false;
			}
			finally{
				return $select;
			}
		}
		private function triagemProdutosComClassificacaoVelha(\PDOStatement $resultadoConsultaGeral) :bool{
			try{
				CB::getConexao()->beginTransaction();
				$query = CB::getConexao()->prepare($this->querys[1]);
				foreach($resultadoConsultaGeral as $linha){
					$resultado = $this->preparaValorParaAtualizacaoNoBanco($linha['Id'], $linha['Classificacoes']);
					if(!$resultado) continue;
					if(!$this->atualizaNaTabelaAsClassificacoes($resultado, $query)) throw new \Exception("não atualizou");
				}
				$retorno = true;
				CB::getConexao()->commit();
			}
			catch(\Exception|\PDOException $e){
				$GLOBALS['ERRO']->setErro("Edicao de classificação", "Na triagem de produtos com classificação velha, {$e->getMessage()}");
				CB::voltaTudo();
				$retorno = false;
			}finally{				
				return $retorno;
			}
		}
		private function atualizaNaTabelaAsClassificacoes(array $parametros, \PDOStatement $conn) :bool{
			try{
				if($conn->execute($parametros)) return true;
				throw new \Exception("falhou na hora de executar a atualização no banco");
			}
			catch(\PDOException $ex){
				$GLOBALS['ERRO']->setErro("Edicao de classificação", "Na atualização do json no banco, {$ex->getMessage()}");
				return false;
			}
			catch(\Exception $ex){
				$GLOBALS['ERRO']->setErro("Edicao de classificação", $ex->getMessage());
				return false;
			}
		}
		private function preparaValorParaAtualizacaoNoBanco(string $id, string $jsonClassificacoes) :array|bool{
			$velhos = json_decode($jsonClassificacoes);
			$localClassVelha = array_search($this->dadosParaExecutar["velho"], $velhos);
			//Verifica a existencia daquela classificação nesse produto
			if($localClassVelha === false) return false; //se não tiver, retorna por aqui

			$velhos[$localClassVelha] = $this->dadosParaExecutar["novo"];
			return [json_encode($velhos), $id];
		}
		private function atualizaValorNoArqvDeClassificacoes(){
			foreach($this->classificacoesSalvas as $inde => $class){
				if($class == $this->dadosParaExecutar['velho']){
					$this->classificacoesSalvas[$inde] = $this->dadosParaExecutar['novo'];
					return;
				}
			}
		}
		function executar(){
			$classificacoesNoBanco = $this->getAllClassificacoesNoBanco();
			$this->atualizaValorNoArqvDeClassificacoes();
			if(!is_bool($classificacoesNoBanco)){
				if($this->triagemProdutosComClassificacaoVelha($classificacoesNoBanco)){
					return "tudo certo";
				}
			}
			return "algo deu errado";
		}
	}