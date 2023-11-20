<?php
  namespace Testes\mensagens;
  
  require "vendor/autoload.php";
  
  use \PHPUnit\Framework\TestCase;
  use App\Servicos\Conexao\ConexaoBanco as CB;
  use App\Mensagem\Consultar as C;
  use App\Mensagem\{
    EnviarMensagem,    
    ExcluirMensagem      
   };

  class MensagensTest extends TestCase {

    function testEnviarMensagemSemArquivos(){
      $envio = new EnviarMensagem("36", "a mlh dela", false);
      $this->assertTrue($envio->getResposta());
    }
    function testConsultarMensagensDeTodosOsUsuarios(){
      $dados = (new C\TodosUsuarios)->getResposta();
      $this->assertIsArray($dados);
    }
    function testExcluirMensagemSemArquivos(){
      $exclusao = new ExcluirMensagem("36",CB::getConexao()->lastInsertId());
      $resultado = $exclusao->getResposta();
      $this->assertIsBool($resultado);
      $this->assertFalse($resultado);
      $this->assertStringContainsString(
        "mas excluiu do banco",
        $exclusao->erro
      );
    }    
  }
