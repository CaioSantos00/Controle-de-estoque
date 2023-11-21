<?php
	namespace Testes\produto;
	
	require "vendor/autoload.php";
	
	use \PHPUnit\Framework\TestCase;
	use App\Servicos\Conexao\ConexaoBanco as CB;
	class ConsultaTest extends TestCase{
		private string $query = "
		SELECT produtoprimario.Nome as nome from `produtoprimario` 
		inner JOIN `produtosecundario` 
		on produtosecundario.parentId = produtoprimario.Id;
		";
		private array $duasQueries = [
			"delete from `produtoprimario` where `Id` = ?",
			"delete from `produtosecundario` where `parentId` = ?"
		];
		function testConsultarTodos(){
			$query = CB::getConexao()->query($this->query);
			$query = $query->fetchAll();
			$nomes = [];
			foreach($query as $resul) $nomes[] = $resul['nome'];			
			$this->assertIsArray($query);
			$this->assertSame(['amortecedor xv3','amortecedor xv3','amortecedor xv3'],$nomes);
		}
		function testExcluirEDpsVoltarAtrasNaQuery(){
			CB::getConexao()->
		}
	}