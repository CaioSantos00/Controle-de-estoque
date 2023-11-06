<?php
	namespace Testes\enderecos;
	require "vendor/autoload.php";
	
    use Testes\Dados;
    use App\Enderecos\Cadastrar;
	use \PHPUnit\Framework\TestCase;
	
	class CadastrarTest extends TestCase{
		private string $idUsuario = "36";

		function testCadastrarEnderecoNormal(){			
			$cadastro = new Cadastrar(
				Dados::$idUsuario,
				"casa",
				$this->dadosEnvio
			);
			$this->assertEquals(true, $cadastro->getResposta());
        }
        function testImpedirDeCadastrarEnderecoComCepErrado(){
            $this->dadosEnvio["Cep"] = "11740000";
            $cadastro = new Cadastrar(
                Dados::$idUsuario,
                "casa",
                $this->dadosEnvio
            );
            $this->assertEquals(json_encode(["Cep"]), $cadastro->getResposta());

        }
        function testImpedirDeCadastrarComCidadeErrada(){
            $this->dadosEnvio["Cidade"] = "ruaRuim123";
            $cadastro = new Cadastrar(
                Dados::$idUsuario,
                "casa",
                $this->dadosEnvio
            );
            $this->assertEquals(json_encode(["Cidade"]),$cadastro->getResposta());
        }
        function testImpedirDeCadastrarStringComCharEspecial(){
            $this->dadosEnvio["InstrucoesEntrega"] = "ru!ARuim$";
            $cadastro = new Cadastrar(
                Dados::$idUsuario,
                "casa",
                $this->dadosEnvio
            );
            $this->assertEquals(json_encode(["InstrucoesEntrega"]),$cadastro->getResposta());       
        }
	}
