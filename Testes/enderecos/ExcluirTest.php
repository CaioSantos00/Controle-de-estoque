<?php
    namespace Testes\enderecos;
    require "vendor/autoload.php";

    use App\Enderecos\Excluir;
    use App\Enderecos\Cadastrar;
    use PHPUnit\Framework\Testcase;
    use Testes\Dados;
    class ExcluirTest extends Testcase{
        private \stdClass $dados;
        function testExcluirEnderecoNormal(){
            $this->dados = (new Dados())->endereco();
            $exclusao = new Excluir(
                $this->dados->idUsuario,
                [$this->dados->certo]
            );
            $resultado = $exclusao->getResposta();
            $this->assertIsBool($resultado);
            $this->assertTrue($resultado);
        }
        function testImpedirExclusaoDeEnderecoInexistente(){            
            $this->dados = (new Dados)->endereco();
            $exclusao = new Excluir(
                $this->dados->idUsuario,
                [$this->dados->errado]
            );
            $this->assertSame(json_encode([$this->dados->errado]),$exclusao->getResposta());
        }
        function testExcluirMultiplosEnderecosCertos(){                                                                    
            $this->dados = (new Dados)->endereco();
            $exclusao = new Excluir(
                $this->dados->idUsuario,
                $this->dados->muitosCertos
            );
            $resultado = $exclusao->getResposta();
            $this->assertIsBool($resultado);
            $this->assertTrue($resultado);
        }
        function testImpedirExclusaoDeMultipliosEnderecosInexistentes(){
            $this->dados = (new Dados)->endereco();
            $exclusao = new Excluir(
                $this->dados->idUsuario,
                $this->dados->muitosErrados
            );
            $resultado = $exclusao->getResposta();
            $this->assertIsString($resultado);
            $this->assertSame(
                json_encode($this->dados->muitosErrados),
                $resultado
            );
        }
        function testExcluirApenasEnderecosExistentesDeListaComEnderecosInexistentes(){            
            $this->dados = (new Dados)->endereco();
            $exclusao = new Excluir(
                $this->dados->idUsuario,
                $this->dados->misturados
            );
            $resultado = $exclusao->getResposta();
            $this->assertIsString($resultado);
            $resultado = array_values(json_decode($resultado));
            $this->assertSame(
                $this->dados->erradosDosMisturados,
                $resultado
            );
        }
    }
