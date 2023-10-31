<?php
    namespace Testes\enderecos;
    
    require_once "vendor/autoload.php";

    use App\Enderecos\Consultar;

    class ConsultarTest extends \PHPUnit\Framework\TestCase{
        private string $idUsuario = "36";
        private string $resultadoEsperado = '[{"Id":28,"0":28,"nomeEndereco":"casa","1":"casa","Cep":"11740-000","2":"11740-000","Cidade":"Itanha\u00e9m","3":"Itanha\u00e9m","Rua":"av lydia","4":"av lydia","Bairro":"Loty","5":"Loty","Numero":"1160","6":"1160","DataCriacao":"29.10.23  11:46","7":"29.10.23  11:46","InstrucoesEntrega":"deixar no vizinho e na rua de baixo","8":"deixar no vizinho e na rua de baixo","dataModificacao":"29.10.23  11:46","9":"29.10.23  11:46"}]';
        function testConsultaNormal(){
            $consulta = new Consultar($this->idUsuario);
            $this->assertIsArray($consulta->getResposta());
            $this->assertEquals($this->resultadoEsperado , json_encode($consulta->getResposta()));
        }
    }
