<?php
    namespace Testes\enderecos;
    
    require_once "vendor/autoload.php";

    use App\Enderecos\Consultar;

    class ConsultarTest extends \PHPUnit\Framework\TestCase{
        private string $idUsuario = "36";
        function testConsultaNormal(){
            $consulta = new Consultar($this->idUsuario);
            $this->assertIsArray($consulta->getResposta());
    	}
	    function testAvisarSobreConsultaSemRetorno(){
    		$consulta = new Consultar("1");
    		$this->assertIsArray($consulta->getResposta());
    		$this->assertEquals(["sem enderecos cadastrados"], $consulta->getResposta());
        }
    }
