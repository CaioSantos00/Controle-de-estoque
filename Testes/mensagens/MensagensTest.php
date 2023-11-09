<?php
  namespace Testes\mensagens;
  require "vendor/autoload.php";
  use \PHPUnit\Framework\TestCase;
  use Testes\Dados;
  use App\Mensagem\{
    EnviarMensagem,
    ConsultarMensagens,
    ExcluirMensagem
   };

  class MensagensTest extends TestCase {
    function testEnviarMensagemSemArquivos(){
      $envio = new EnviarMensagem("36", "a mlh dela", false);
      $this->assertTrue($envio->getResposta());
    }
    function testEnviarMensagemComArquivos(){
      $_FILES['imgs']['tmp_name'][0]
    }
  }
