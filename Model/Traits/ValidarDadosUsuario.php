<?php
	namespace App\Traits;
	
	trait ValidarDadosUsuario{
		private bool $valido = true;
		private array $dadosErrados = [];
		
		private function validar(array $dados){
			if(!filter_var($dados['email'],FILTER_VALIDATE_EMAIL)) $this->dadosErrados[] = 'email';
			$tamanhoTelefone = strlen($dados['telefone']);
			if($tamanhoTelefone > 15 or $tamanhoTelefone < 9) $this->dadosErrados[] = 'telefone';
			
			if(count($this->dadosErrados) > 0) $this->valido = false;
		}
	}