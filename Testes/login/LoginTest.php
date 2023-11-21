<?php
	namespace Testes\login;
	
	require "vendor/autoload.php";
		
	use App\Usuario\Login;
	use \PHPUnit\Framework\TestCase;	
	
	class LoginTest extends TestCase{
		
		public function testLoginCerto() :void{
			$login = new Login("felipeluizmsouza@gmail.com","relinha123", true);
			$resultado = $login->getResposta();
		
			$this->assertSame("logou certinho", $resultado);
		}
		
		public function testLoginErrado() :void{
			$login = new Login("felipeluizmsouza@gmail.com","reli", true);
			$this->assertSame("usuario não encontrado", $login->getResposta());
		}
	}