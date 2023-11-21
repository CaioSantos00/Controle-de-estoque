<?php
	namespace App\Carrinho;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Usuario\Perfil as PerfilUser;
	use App\Interfaces\Model;
	
	class ConsultarFinalizados implements Model, \Stringable{
		private string $query = "select * from `carrinhosfinalizados`";
		
		private function consultarCarrinhos() :array{
			CB::getConexao()->beginTransaction();
				$retorno = CB::getConexao()->query($this->query);
			CB::getConexao()->commit();
			
			return ($retorno === false) ? [] : [...$retorno];
		}
		private function getDadosDonoCarrinho(string $idUsuario) :array{
			$dono = (new Perfil(bin2hex($carrinho['IdDono'])))->getResposta();
			foreach($dono[1] as $user){
				$dados = [
					$user['Nome'],
					$user['Email'],
					$user['Telefone']
				];
			}			
			return [$dono[0], $dados];
		}
		private function getCarrinhosComDonos(array $carrinhos) :array{
			$retorno = [];
			foreach($carrinhos as $carrinho){				
				$retorno[] = [
					$carrinho['Id'],
					$carrinho['Data'],
					json_decode($carrinho['Conteudo']),
					$this->getDadosDonoCarrinho($carrinho['IdDono'])
				];
			}
			return $retorno;
		}
		function __toString(){
			return json_encode($this->getResposta());
		}
		function getResposta() :array{
			return $this->getCarrinhosComDonos($this->consultarCarrinhos());
		}
	}