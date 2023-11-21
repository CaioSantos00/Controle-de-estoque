<?php
	namespace Testes\usuario;
	require "vendor/autoload.php";
	
	use App\Usuario\{
		ConsultarTodos,
		Perfil
	};
	use Testes\Dados;
	use \PHPUnit\Framework\TestCase;
	
	class ConsultaTest extends TestCase{
		function testBuscarDadosDePerfilDeUsuarioNormal(){
			$perfil = new Perfil(bin2hex(Dados::$idUsuario));
			$perfil = (string) $perfil;
			$this->assertIsString($perfil);
			$this->assertSame( //String de exemplo de retorno
				'["arqvsSecundarios\/FotosUsuarios\/36.png",[{"Nome":"felipe luiz mariano de souza","0":"felipe luiz mariano de souza","Email":"felipeluizmsouza@gmail.com","1":"felipeluizmsouza@gmail.com","Telefone":"+5513997673802","2":"+5513997673802","Carrinho":"[]","3":"[]","TipoConta":1,"4":1}]]',
				$perfil
			);
		}
		function testImpedirBuscarDadosDePerfilDeUsuarioQueNaoExiste(){
			$perfil = new Perfil(bin2hex("0"));
			$perfil = (string) $perfil;
			$this->assertIsString($perfil);
			$this->assertSame(
				'["imagem n\u00e3o encontrada","perfil n\u00e3o encontrado"]',
				$perfil
			);
		}
		function testConsultarTodosOsDadosDeTodosOsUsuariosNormais(){
			$users = new ConsultarTodos;
			$users = (string) $users;
			$this->assertIsString($users);
			$this->assertSame(
				'[{"Id":36,"0":36,"Nome":"felipe luiz mariano de souza","1":"felipe luiz mariano de souza","Email":"felipeluizmsouza@gmail.com","2":"felipeluizmsouza@gmail.com","Telefone":"+5513997673802","3":"+5513997673802"}]',
				$users
			);
		}
		function testImpedirDeFazerConsultaComParametrosErrados(){
			$users = new ConsultarTodos;
			$users->setParametros("ablublublu");
			$users = (string) $users;
			$this->assertIsString($users);
			$this->assertSame(
				'[false]',
				$users
			);
		}
	}