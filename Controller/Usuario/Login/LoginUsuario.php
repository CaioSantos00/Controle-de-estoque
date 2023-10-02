<?php
	use App\Servicos\Login\Login;
	
	if(isset($_POST['submit'])){
		$usuario = new Login($_POST['Email'], $_POST['Senha']);
		echo $usuario->getResposta();
	}