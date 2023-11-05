<?php
	namespace Testes\enderecos;
	
	require "vendor/autoload.php";
	
	use App\Enderecos\Editar;
	use PHPUnit\Framework\TestCase;
	use Testes\Dados;
	
	class EditarTest extends TestCase{
		function testEditaEnderecoNormal(){
			$dados = (new Dados())->edicaoEndereco();
			$edicao = new Editar(
				Dados::$idUsuario,
				$dados->IdCerto,
				$dados->dadosCertos
			);			
			$resposta = $edicao->getResposta();
			$this->assertSame(true,$resposta);
		}
		function testImpedirDeEditarComDadosErrados(){
			$dados = (new Dados())->edicaoEndereco();
			$dados->dadosCertos["cep"] = "177777777777";
			$edicao = new Editar(
				Dados::$idUsuario,
				$dados->IdCerto,
				$dados->dadosCertos
			);			
			$resposta = $edicao->getResposta();
			$this->assertSame(["177777777777"],$resposta);
		}
	}