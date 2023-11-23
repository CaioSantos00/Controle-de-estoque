<?php
	namespace Testes\classificacoes;

	require "vendor/autoload.php";
	use \PHPUnit\Framework\TestCase;
    use App\Servicos\Arquivos\Produtos\Classificacoes\Excluir as E;


	class SoEdicaoTest extends TestCase{
        function testExcluirClassificacao(){
            $e = new E("cheiroso");
            $this->assertSame("tudo certo", $e->executar());
        }
    }
