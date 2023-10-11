<?php
	namespace App\Usuario;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Usuario\Perfil as PUnico;
	use App\Interfaces\ServicoInterno;
	use App\Interfaces\Model;
	
	class ConsultarTodos implements ServicoInterno, Model, Stringable{
		private string $query = "select `Id`, `Nome`, `Email`, `Telefone` from `usuario`";
		
		function setParametros(string $parametros){
			$this->query = "select {$parametros} from `usuario`";
		}
		function executar() :array{
			try{
				CB::getConexao()->beginTransaction();
					$resultado = CB::getConexao()
									->query($this->query);
				CB::getConexao()->commit()
			}
			catch(\Exception|\PDOException $e){
				$GLOBALS['ERRO']->setErro("Consulta usuario", "na query: {$e->getMessage()}");
				if(CB::getConexao()->inTransaction()) CB::getConexao()->rollBack();
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
			return $this->executar();
		}
	}