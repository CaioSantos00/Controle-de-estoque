<?php
	namespace App\Traits;
	
	trait OrganizarDadosConsulta{
		private function organizar(array &$resul, array $resultadoDaConsulta){
			$x = 0;
			foreach($resultadoDaConsulta as $consulta){
				$resul[$x] = new \stdClass;
				foreach($consulta as $chav => $valor){
					if(!is_string($chav)) continue;
					$resul[$x]->$chav = $valor;
				}
				$x++;
			}
		}	
	}