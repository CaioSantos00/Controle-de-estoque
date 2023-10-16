<?php
	//require __DIR__."/vendor/autoload.php";
	
	use PHPUnit\Framework\TestCase;
	
	final class AdicionarItemTest extends TestCase{
		
		function testSaudacao(){
		$ola = "aaa";
		$this->assertSame("aaaa", $ola);}
	}