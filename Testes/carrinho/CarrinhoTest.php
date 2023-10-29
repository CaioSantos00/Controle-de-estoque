<?php
    namespace Testes\carrinho;

	require "vendor/autoload.php";

	use Controladores\Rotas\RotasUser\UserRequests;
    use App\Carrinho\Consultar;
    use App\Carrinho\Finalizar;
    use App\Carrinho\SalvarNovo;
	use \PHPUnit\Framework\TestCase;

    class CarrinhoTest extends TestCase{
        private string $idUsuario = "36";
        function testEsvaziarCarrinho(){
            $carrinho = new SalvarNovo([], $this->idUsuario);
            
            $this->assertEquals(true, $carrinho->executar());
        }
        function testAdicionarItem(){
            $carrinho = new UserRequests\CarrinhoRequests;
            $resultado = $carrinho
                ->adicionarItem([
                    "login" => $this->idUsuario,
                    "idVariacao" => "1",
                    "qtd" => "50"
                ]);

            $this->assertEquals("1", $resultado);
        }
        function testRemoverItem(){
            $carrinho = new UserRequests\CarrinhoRequests;
            $resultado = $carrinho
                ->removerItem([
                    "login" => $this->idUsuario,
                    "idVariacao" => "1",
                    "qtd" => "50"
                ]);

            $this->assertEquals(true, $resultado);
        }
        function testConsultaGeral(){
            $carrinho = new Consultar();
            $carrinho->executar($this->idUsuario);

            $this->assertEquals('[]', (string) $carrinho);
        }
        function testFinalizarCarrinho(){
            $this->testAdicionarItem();
            $carrinho = new Finalizar($this->idUsuario);

            $this->assertEquals(true, $carrinho->getResposta());
        }
        function testEsvaziarCarrinhoDenovo(){
            $carrinho = new SalvarNovo([], $this->idUsuario);
            
            $this->assertEquals(true, $carrinho->executar());
        }        
    }