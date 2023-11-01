<?php
    namespace Testes\enderecos;
    
    require_once "vendor/autoload.php";

    use App\Enderecos\Consultar;

    class ConsultarTest extends \PHPUnit\Framework\TestCase{
        private string $idUsuario = "36";
        private string $resultadoEsperado = '[{"Id":32,"0":32,"nomeEndereco":"casa","1":"casa","Cep":"11740-000","2":"11740-000","Cidade":"Itanha\u00e9m","3":"Itanha\u00e9m","Rua":"av lydia","4":"av lydia","Bairro":"Loty","5":"Loty","Numero":"1160","6":"1160","DataCriacao":"30.10.23  8:05","7":"30.10.23  8:05","InstrucoesEntrega":"ru!ARuim$","8":"ru!ARuim$","dataModificacao":"30.10.23  8:05","9":"30.10.23  8:05"}]';
        function testConsultaNormal(){
            $consulta = new Consultar($this->idUsuario);
            $this->assertIsArray($consulta->getResposta());
            $this->assertEquals($this->resultadoEsperado,json_encode($consulta->getResposta()));
	}
	function testAvisarSobreConsultaSemRetorno(){
		$consulta = new Consultar("1");
		$this->assertIsArray($consulta->getResposta());
		$this->assertEquals(["sem enderecos cadastrados"], $consulta->getResposta());
	}
    }
