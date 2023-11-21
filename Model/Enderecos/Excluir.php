<?php
	namespace App\Enderecos;

	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\Model;

	class Excluir implements Model{
		private string $idUsuario;
		private array $idsEnderecos;
		private array $idsErrados = [];
		private bool $temIdErrado = false;
		private string $query = "delete from `enderecos` where `IdDono` = ? and `Id` = ?";
		function __construct(string $idUsuario, array $idsEnderecos){
			$this->idUsuario = $idUsuario;
			$this->idsEnderecos = $idsEnderecos;
		}
		private function excluiDoBanco() :bool{
			try{
				$resultado = true;
				CB::getConexao()->beginTransaction();
				$query = CB::getConexao()->prepare($this->query);
				foreach($this->idsEnderecos as $endereco){					
					$query->execute([$this->idUsuario, $endereco]);					
					$result = $query->rowCount();					
					if($result == 0){
					   	$this->temIdErrado = true;
						$this->idsErrados[] = $endereco;					
					}
				}
				CB::getConexao()->commit();				
			}
			catch(\PDOException $ex){
				$GLOBALS['ERRO']->setErro("excluir endereco", $ex->getMessage());
				$resultado = false;
				CB::voltaTudo();
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro("excluir endereco", $e->getMessage());
				$resultado = false;
				CB::voltaTudo();
			}
			finally{
				return $resultado;
			}
		}
		function getResposta(){
			if($this->excluiDoBanco()){
				if($this->temIdErrado) return json_encode($this->idsErrados);
				return true;
			}
			return false;
		}
	}
