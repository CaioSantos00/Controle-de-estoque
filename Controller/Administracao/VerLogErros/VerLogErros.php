<?php
	use App\Servicos\ErrorLogging\VisualizarLogErros\VisualizarLogErros as VerLogErros;
	
	if(isset($_POST['verTodos'])){		
		echo new VerLogErros();		
	}