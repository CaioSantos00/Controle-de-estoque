<?php
	namespace App\Servicos\Arquivos\Produtos\Classificacoes;

	use App\Interfaces\ServicoInterno;
	use App\Servicos\Arquivos\Produtos\Classificacoes\Classificacoes;
	use App\Servicos\Conexao\ConexaoBanco as CB;

	class Edicao extends Classificacoes implements ServicoInterno{
		private array $querys;
		private array $dadosParaExecutar;
		function __construct(string $paraEditar, string $novoValor){
			parent::__construct();
			$this->querys = [
				"select `Id`,`Classificacoes` from `produtoPrimario`",
				"update `produtoprimario` set `Classificacoes` = ? where `Id` = ?"
			];
			$this->dadosParaExecutar = array(
				"novo" => $novoValor,
				"velho" => $paraEditar
			);
		}
		private function getAllClassificacoesNoBanco() :array|bool{
			try{
				CB::getConexao()->beginTransaction();
				$select = CB::getConexao()
					->query($this->querys[0]);
				CB::getConexao()->commit();
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro("Edicao de classificação", "Na conexao da consulta: {$e->getMessage()}");
				if(CB::getConexao()->inTransaction()) CB::getConexao()->rollBack();
				$select = false;
			}
			catch(\PDOException $e){
				$GLOBALS['ERRO']->setErro("Edicao de classificação", "Na execução da query de consulta: {$e->getMessage()}");
				if(CB::getConexao()->inTransaction()) CB::getConexao()->rollBack();
				$select = false;
			}
			finally{
				return $select;
			}
		}
		private function triagemProdutosComClassificacaoVelha(array $resultadoConsultaGeral){
			try{
				CB::getConexao()->beginTransaction();
				$query = CB::getConexao()->prepare($this->querys[1]);			
				foreach($resultadoConsultaGeral as $linha){
					$resultado = $this->preparaValorParaAtualizacaoNoBanco(...$linha);
					if(!$resultado) throw new \Exception("não deu para preparar");
					if(!$this->atualizaNaTabelaAsClassificacoes($resultado, $query)) throw new \Exception("não atualizou");
				}
				CB::getConexao->commit();
				return true;
			}
			catch(\Exception|\PDOException $e){
				$GLOBALS['ERRO']->setErro("Edicao de classificação", "Na triagem de produtos com classificação velha, {$e->getMessage()}");
				return false;
			}
		}
		private function atualizaNaTabelaAsClassificacoes(array $parametros, \PDOStatement $conn){
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
		private function preparaValorParaAtualizacaoNoBanco(string $id, string $jsonClassificacoes){
			$velhos = json_decode($jsonClassificacoes);
			$localClassVelha = array_search($this->dadosParaExecutar["velho"], $velhos);
			//Verifica a existencia daquela classificação nesse produto
			if($localClassVelha === false) return false; //se não tiver, retorna por aqui

			$velhos[$localClassVelha] = $this->dadosParaExecutar["novo"];
			return [json_encode($velhos), $id];
		}
		function executar(){
			$classificacoesNoBanco = $this->getAllClassificacoesNoBanco();
			if(is_array($classificacoesNoBanco)){
				if($this->triagemProdutosComClassificacaoVelha($classificacoesNoBanco)){
					
				}
			}
			
		}
	}