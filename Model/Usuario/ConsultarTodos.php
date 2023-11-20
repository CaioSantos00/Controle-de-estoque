<?php
	namespace App\Usuario;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Usuario\Perfil as PUnico;
	use App\Interfaces\ServicoInterno;
	use App\Interfaces\Model;
	
	class ConsultarTodos implements ServicoInterno, Model, \Stringable{
		private string $query = "select `Id`, `Nome`, `Email`, `Telefone` from `usuario`";
		private array $resposta;
		
		function setParametros(string $parametros){
			$this->query = "select {$parametros} from `usuario`";
		}
		function executar(){
			try{
				$resultado = CB::getConexao()
					->query($this->query)
					->fetchAll();
			}
			catch(\Exception|\PDOException $e){
				$GLOBALS['ERRO']->setErro("Consulta usuario", "na query: {$e->getMessage()}");
				$resultado = [false];
			}
			finally{
				return $resultado;
			}
		}
		function __toString(){
			return json_encode($this->getResposta());
		}
		function getResposta(){
			if(empty($this->resposta)) $this->resposta = $this->executar();
			return $this->resposta;
		}
	}