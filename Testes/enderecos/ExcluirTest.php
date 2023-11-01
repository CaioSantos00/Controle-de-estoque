<?php
    namespace Testes\enderecos;
    require "vendor/autoload.php";

    use App\Enderecos\Excluir;
    use App\Enderecos\Cadastrar;
    use PHPUnit\Framework\Testcase;
    use Testes\Dados;
    class ExcluirTest extends Testcase{
        private \stdClass $dados;       

        function testCadastraParaTestes(){
            
        }
        function testExcluirEnderecoNormal(){
            $this->dados = (new Dados())->endereco();
            $exclusao = new Excluir(
                $this->dados->idUsuario,
                [$this->dados->certo]
            );
            $resultado = $exclusao->getResposta();
            $this->assertSame(true, $resultado);
        }
        function testImpedirExclusaoDeEnderecoInexistente(){            
            $this->dados = (new Dados)->endereco();
            $exclusao = new Excluir(
                $this->dados->idUsuario,
                [$this->dados->errado]
            );
        }
        function testExcluirMultiplosEnderecosCertos(){                                                                    
            $this->dados = (new Dados)->endereco();
            $exclusao = new Excluir(
                $this->dados->idUsuario,
                $this->dados->multiplosCertos
            );
        }/*
        function testImpedirExclusaoDeMultipliosEnderecosInexistentes(){
            $this->dados = (new Dados)->endereco();
            $exclusao = new Excluir(
                $this->dados->idUsuario,[
                     
                ]
            );
        }
        function testExcluirApenasEnderecosExistentesDeListaComEnderecosInexistentes(){            
            $this->dados = (new Dados)->endereco();
            $exclusao = new Excluir(); 
        }*/
    }
