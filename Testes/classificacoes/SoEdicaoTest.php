<?php
	namespace Testes\classificacoes;

	require "vendor/autoload.php";
	use \PHPUnit\Framework\TestCase;
    use App\Servicos\Arquivos\Produtos\Classificacoes\Edicao as E;


	class SoEdicaoTest extends TestCase{
        function testExcluirClassificacao(){
            $e = new E("cheirosinho", "não tão cheiroso");
            $this->assertSame("tudo certo", $e->executar());
        }
    }
