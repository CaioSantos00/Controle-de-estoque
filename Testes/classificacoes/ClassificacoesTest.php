<?php
	namespace Testes\classificacoes;
	
	require "vendor/autoload.php";
	use Controladores\Rotas\RotasAdm\AdmRequests\ClassificacoesRequests;
	use \PHPUnit\Framework\TestCase;
	
	class ClassificacoesTest extends TestCase{
		public function testCadastrarNova() :void{
			$teste = new ClassificacoesRequests();
			$saida = $teste->cadastrar(["nome"=>"coisas"]);
			
			$this->assertEquals("cadastrou nova", $saida->saida);
		}
		public function testCadastraJaExistente() :void{
			$teste = new ClassificacoesRequests();
			$saida = $teste->cadastrar(["nome"=>"coisas"]);
			
			$this->assertEquals("ja tava cadastrado", $saida->saida);
		}
		public function testEditaUmaQueJaExiste() :void{
			$teste = new ClassificacoesRequests();
			$saida = $teste->edicao([
			"paraEditar" 	=> "coisas",
			"novoValor" 	=> "coisado"
			]);
			
			$this->assertEquals("tudo certo", $saida);
		}
		public function testRetornarTodasClassificacoes() :void{
			$teste = new ClassificacoesRequests();
			$saida = $teste->consultar([]);
			$this->assertEquals(json_encode(["coisado"]), (string) $saida);
		}		
		public function testExcluirClassificacao() :void{
			$teste = new ClassificacoesRequests();
			$saida = $teste->excluir(["paraExcluir"=>"coisado"]);			
			$this->assertEquals("tudo certo", $saida);			
		}
		public function testRetornarNovamenteTodasClassificacoes() :void{
			$teste = new ClassificacoesRequests();
			$saida = $teste->consultar([]);
			$this->assertEquals(json_encode([]), (string) $saida);
		}
		public function testAtualizarArquivo() :void{			
			$teste = new ClassificacoesRequests();
			$saida = $teste->atualizarArqv([]);
			
			$this->assertEquals($saida, true);
		}		
	}