<?php
    namespace Testes\carrinho;

	require "vendor/autoload.php";

    use App\Carrinho\Finalizar;
    use App\Carrinho\SalvarNovo;
	use \PHPUnit\Framework\TestCase;

    class FinalizarTest extends TestCase{
        private string $idUsuario = "36"
        function testEsvaziarCarrinho(){
            $carrinho = new SalvarNovo([], $this->idUsuario);            
            $this->assertEquals(true, $carrinho->executar());
        }

        function testFinalizarCarrinhoComConteudoNormal(){
            $carrinho = new Finalizar($this->idUsuario);
            $this->assertEquals(true, $carrinho->getResposta());
        }
    }
