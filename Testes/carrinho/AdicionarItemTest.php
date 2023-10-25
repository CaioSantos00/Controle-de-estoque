<?php
    namespace Testes\carrinho;
    	
	require "vendor/autoload.php";
		
	use Controladores\Rotas\RotasUser\UserRequests;
	use \PHPUnit\Framework\TestCase;	
	
    class AdicionarItemTest extends TestCase{
        function testAdicionarItemNormalmente(){
            $carrinho = new UserRequests\CarrinhoRequests;
            $resultado = $carrinho
                ->adicionarItem([
                    "login" => "6",
                    "idVariacao" => "1",
                    "qtd" => "10"
                ]);
            
            $this->assertEquals("1", $resultado);
        }
        function testAdicionarItemQueNaoExiste(){
            $carrinho = new UserRequests\CarrinhoRequests;
            $resultado = $carrinho
                ->adicionarItem([
                    "login" => "6",
                    "idVariacao" => "999999",
                    "qtd" => "1"
                ]);
            
            $this->assertEquals("tentou adicionar no carrinho uma variacao que não existe", $resultado);
        }
        function testAdicionarUmaQuantidadeMaiorDoQueTemCadastradadoDeUmItemEspecifico(){
            $carrinho = new UserRequests\CarrinhoRequests;
            $resultado = $carrinho
                ->adicionarItem([
                    "login" => "6",
                    "idVariacao" => "2",
                    "qtd" => "9999999"
                ]);
            
            $this->assertEquals("tentou adicionar mais doque tem disponivel", $resultado);
        }
    }