<?php
    namespace Testes\carrinho;
    	
	require "vendor/autoload.php";
		
	use Controladores\Rotas\RotasUser\UserRequests;
    use App\Carrinho\Consultar;
	use \PHPUnit\Framework\TestCase;
	
    class CarrinhoTest extends TestCase{
        function testAdicionarItem(){
            $carrinho = new UserRequests\CarrinhoRequests;
            $resultado = $carrinho
                ->adicionarItem([
                    "login" => "6",
                    "idVariacao" => "1",
                    "qtd" => "10"
                ]);
            
            $this->assertEquals("1", $resultado);
        }
        function testRemoverItem(){
            $carrinho = new UserRequests\CarrinhoRequests;
            $resultado = $carrinho
                ->removerItem([
                    "login" => "6",
                    "idVariacao" => "1",
                    "qtd" => "10"
                ]);
                
            $this->assertEquals(true, $resultado);
        }
        function testConsultaGeral(){
            $carrinho = new Consultar();
            $carrinho->executar("6");
            
            $this->assertEquals('[{"produto":"1","quantidade":120}]', (string) $carrinho);
        }
    }