<?php
	namespace Testes\login;
	
	use App\Usuario\Login;
	use \PHPUnit\Framework\TestCase;	
	
	class LoginTest extends TestCase{
		
		public function testLoginCerto() :void{
			$login = new Login("felipeluizmsouza@gmail.com","relinha123");
			$resultado = $login->getResposta();
			
			if(isset($_COOKIE['login']))
				setcookie("login", $_COOKIE['login'],0);
				
			if(isset($_COOKIE['TipoConta'])) setcookie("TipoConta", $_COOKIE['TipoConta'],0);
			$this->assertSame("logou certinho", $resultado);
		}
		
		public function testLoginErrado() :void{
			$login = new Login("felipeluizmsouza@gmail.com","reli");
			$this->assertSame("usuario não encontrado", $login->getResposta());
		}
	}