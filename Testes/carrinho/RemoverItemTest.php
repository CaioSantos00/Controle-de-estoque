<?php
    namespace Testes\carrinho;
    
    require "vendor/autoload.php";
    
	use Controladores\Rotas\RotasUser\UserRequests;
	use \PHPUnit\Framework\TestCase;
    
    class RemoverItem extends TestCase{
        function testRemoverItemQueEstaNoCarrinho(){
            $carrinho = new UserRequests\CarrinhoRequests;
            $resultado = $carrinho
                ->removerItem([
                    "login" => "6",
                    "idVariacao" => "1",
                    "qtd" => "10"
                ]);
                
            $this->assertEquals(true, $resultado);
        }
        function testRemoverItemQueNaoEstaNoCarrinho(){
            $carrinho = new UserRequests\CarrinhoRequests;
            $resultado = $carrinho
                ->removerItem([
                    "login" => "6",
                    "idVariacao" => "50000",
                    "qtd" => "10"
                ]);
            
            $this->assertEquals(true, $resultado);            
        }
        function testRemoverQuantidadeAbsurdaDeItemQueEstaNoCarrinho(){
            $carrinho = new UserRequests\CarrinhoRequests;
            $resultado = $carrinho
                ->removerItem([
                    "login" => "6",
                    "idVariacao" => "1",
                    "qtd" => "9999999"
                ]);
            
            $this->assertEquals(true, $resultado);            
        }
    }