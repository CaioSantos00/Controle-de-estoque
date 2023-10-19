<?php
	namespace App\Mensagem;
	
	use App\Interfaces\Model;
	use App\Conexao\ConexaoBanco as CB;
	
	class EnviarMensagem implements Model{
		private string $query = "";
		function __construct(string $idUsuario){
			
		}
		private function salvarImagens(){
		}
		function getResposta(){
			
		}
	}