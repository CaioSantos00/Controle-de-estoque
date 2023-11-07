<?php
    namespace Testes\descricao;

    require "vendor/autoload.php";

    use \PHPUnit\Framework\TestCase;
    use App\Servicos\Arquivos\Produtos\Descricoes as D;

    class DescricaoGeralTest extends TestCase{
      function testCriarESalvarUmaDescricao(){
        $descricao = new D\CriarDescricao("150150150", "uma descrição ótima para testar");
        $this->assertTrue($descricao->executar());
      }
      function testConsultarUmaDescricao(){
        $descricao = new D\BuscarDescricao("150150150");
        $this->asserSame("uma descrição ótima para testar", (string) $descricao);
      }
      function testEditarUmaDescricao(){
        $descricao = new D\EditarDescricao("150150150", "uma descrição ótima para editar");
        $this->assertTrue($descricao->executar());
      }
      function testExcluirUmaDescricao(){
        $descricao = new D\ExcluirDescricao("150150150");
        $this->assertTrue($descricao->executar());
      }
    }
