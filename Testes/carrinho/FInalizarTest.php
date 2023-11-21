<?php
    namespace Testes\carrinho;

	require "vendor/autoload.php";
    
	use Controladores\Rotas\RotasUser\UserRequests\CarrinhoRequests;
    use App\Carrinho\Finalizar;
    use App\Carrinho\SalvarNovo;
	use \PHPUnit\Framework\TestCase;

    class FinalizarTest extends TestCase{
        private string $idUsuario = "36";

        function testEsvaziarCarrinho(){
            $carrinho = new SalvarNovo([], $this->idUsuario);            
            $this->assertEquals(true, $carrinho->executar());
        }
        function testAdicionarItem(){
            $carrinho = new CarrinhoRequests;
            $resultado = $carrinho
                ->adicionarItem([
                    "login" => $this->idUsuario,
                    "idVariacao" => "1",
                    "qtd" => "50"
                ]);

            $this->assertEquals("1", $resultado);
        }
        function testFinalizarCarrinhoComConteudoNormal(){
            $carrinho = new Finalizar($this->idUsuario);
            $this->assertEquals(true, $carrinho->getResposta());
        }
        function testImpedirDeFinalizarCarrinhoVazio(){
            $carrinho = new Finalizar($this->idUsuario);
            $this->assertEquals(false, $carrinho->getResposta());
        }
        function testImpedirDeFinalizarCarrinhoDeUsuarioQueNaoExiste(){
            $carrinho = new Finalizar("99999");
            $this->assertEquals(false, $carrinho->getResposta());
        }
    }
