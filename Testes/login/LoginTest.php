<?php
	namespace Testes\login;

	require "vendor/autoload.php";
	use \PHPUnit\Framework\TestCase;
	use App\Usuario\Login;
	
	class LoginTest extends TestCase{
		
		public function testLoginCerto() :void{
			$login = new Login("felipeluizmsouza@gmail.com","relinha123");
			$resultado = $login->getResposta();
			setcookie("login", $_COOKIE['login'],0);
			if(isset($_COOKIE['TipoConta'])) setcookie("TipoConta", $_COOKIE['TipoConta'],0);
			$this->assertSame("logou certinho", $resultado);
		}
		
		public function testLoginErrado() :void{
			$login = new Login("felipeluizmsouza@gmail.com","reli");
			$this->assertSame("usuario não encontrado", $login->getResposta());
		}
	}