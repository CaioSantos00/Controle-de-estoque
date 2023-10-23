<?php
	namespace Testes\classificacoes;
	
	require "vendor/autoload.php";
	use Controladores\Rotas\RotasAdm\AdmRequests\ClassificacoesRequests;
	use \PHPUnit\Framework\TestCase;
	
	class ClassificacoesTest extends TestCase{
		public function testCadastrarNova() :void{
			$teste = new ClassificacoesRequests();
			$saida = $teste->cadastrar(["nome"=>"sucrilho"]);
			
			$this->assertEquals("cadastrou nova", $saida->saida);
		}
		public function testCadastraJaExistente() :void{
			$teste = new ClassificacoesRequests();
			$saida = $teste->cadastrar(["nome"=>"sucrilho"]);
			
			$this->assertEquals("ja tava cadastrado", $saida->saida);
		}
		public function testEditaUmaQueJaExiste() :void{
			$teste = new ClassificacoesRequests();
			$saida = $teste->edicao([
			"paraEditar" 	=> "não tão dahora",
			"novoValor" 	=> "dahora"
			]);
			
			$this->assertEquals("tudo certo", $saida);
		}
		public function testExcluirClassificacao() :void{
			$teste = new ClassificacoesRequests();
			$saida = $teste->excluir(["paraExcluir"=>"dahora"]);
			
			$this->assertEquals("tudo certo", $saida);			
		}
		public function testRetornarTodasClassificacoes() :void{
			$teste = new ClassificacoesRequests();
			$saida = $teste->consultar([]);
			
			$this->assertEquals(json_encode(['sucrilho']), (string) $saida);
		}
		public function testAtualizarArquivo() :void{
			$teste = new ClassificacoesRequests();
			$saida = $teste->atualizarArqv([]);
			
			$this->assertEquals($saida, true);
		}
	}