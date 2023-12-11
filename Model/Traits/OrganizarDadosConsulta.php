<?php
	namespace App\Traits;

	trait OrganizarDadosConsulta{
		private function organizar(array &$resul, array $resultadoDaConsulta, bool $array = false){
			$x = 0;
			foreach($resultadoDaConsulta as $consulta){
				$resul[$x] = $array ? [] : new \stdClass;
				foreach($consulta as $chav => $valor){
					if(!is_string($chav)) continue;
					if($array){
						$resul[$x][$chav] = $valor;
						continue;
					}
					$resul[$x]->$chav = $valor;
				}
				$x++;
			}
		}
	}
