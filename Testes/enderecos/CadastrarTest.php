<?php
	namespace Testes\enderecos;
	require "vendor/autoload.php";
	
	use App\Enderecos\Cadastrar;
	use \PHPUnit\Framework\TestCase;
	
	class CadastrarTest extends TestCase{
		private string $idUsuario = "36";
		private array $dadosEnvio = [
			"Cep" => "11740000",
			"Cidade" => "Itanhaém",
			"Rua" => "av lydia",
			"Bairro" => "Loty",
			"Numero" => "1160",
			"InstrucoesEntrega" => "deixar no vizinho e na rua de baixo"			
		];
		function testCadastrarEnderecoNormal(){
			$cadastro = new Cadastrar(
				$this->idUsuario,
				"casa",
				$this->dadosEnvio
			);
			$this->assertTrue($cadastro->getResposta());
		}
	}