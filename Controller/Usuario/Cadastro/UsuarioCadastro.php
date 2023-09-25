<?php
	use Cadastro\Usuario\NovoUsuario;
	
	if(isset($_POST['submit'])){
		$cadastro = new NovoUsuario();
		
		$dadosUsuario = [
			$_POST['Nome'],
			$_POST['Email'],
			$_POST['Senha'],
			$_POST['Telefone'],
			0
		];
		
		$resultado = [
			$cadastro->setDadosUsuario($dadosUsuario),
			$cadastro->setFotoUsuario()
		]
		switch($resultado){
			case [true, true];
				echo "tudo certo";
				break;
			case [false, true];
				echo "foto ok, outros dados não";
				break;
			case [true, false];
				echo "dados ok, foto não";
				break;
			case [false, false];
				echo "tudo deu errado";
				break;
			default;
				echo "inrastreável";
		}
	}