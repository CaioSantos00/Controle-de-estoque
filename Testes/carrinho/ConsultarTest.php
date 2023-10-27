<?php
    namespace Testes\carrinho;
    
    require "vendor/autoload.php";
    
    use \PHPUnit\Framework\TestCase;
    use App\Carrinho\Consultar;
    
    class ConsultarTest extends TestCase{
        
        function testConsultaNormal(){
            $consulta = (new Consultar())->executar("6");
            
        }
    }