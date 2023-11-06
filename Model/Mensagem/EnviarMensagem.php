<?php
	namespace App\Mensagem;
	
	use App\Interfaces\Model;
	use App\Conexao\ConexaoBanco as CB;
	
	class EnviarMensagem implements Model{
		private string $query = "";
		private string $idUsuario;
		function __construct(string $idUsuario){
			$this->idUsuario = $idUsuario;
		}
		private function salvarImagens(){
			$qtdImgs = count($_FILES['imgs']['tmp_name']);
			for($x = 0;$x != $qtdImgs; $x++){
				
			}
		}
		function getResposta(){
			
		}
	}
