<?php
	use App\Servicos\ErrorLogging\VisualizarLogErros\VisualizarLogErros as VerLogErros;

	class RotasAdm{
		private 
		function verLogErros(){
			if(isset($_POST['verTodos'])){
				echo new VerLogErros();
			}
		}
	}