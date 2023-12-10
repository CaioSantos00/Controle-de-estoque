<?php
	namespace App\Carrinho;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Usuario\Perfil as PerfilUser;
	use App\Interfaces\Model;
	use App\Enderecos\Consultar as CEndereco;
	
	class ConsultarFinalizados implements Model, \Stringable{
		private string $query = "select * from `carrinhosfinalizados`";
		
		private function consultarCarrinhos() :array{
			$retorno = CB::getConexao()->query($this->query);
			
			return ($retorno === false)
				? []
				: $retorno->fetchAll();
		}
		private function getDadosDonoCarrinho(string $idUsuario) :array|string{
			$dono = (new PerfilUser($idUsuario +1,false))->getResposta();
			
			return is_array($dono["dados"])
				? [$dono["imagem"],$dono["dados"]['Nome'],$dono["dados"]['Email'],$dono["dados"]['Telefone']]
				: "dono do carrinho não encontrado";
		}
		private function getCarrinhosComDonos(array $carrinhos) :array{
			$retorno = [];
			foreach($carrinhos as $carrinho){
				if(is_string($dadosDono = $this->getDadosDonoCarrinho($carrinho['IdDono']))) continue;
				$retorno[] = [
					$carrinho['Id'],
					$carrinho['Data'],
					$carrinho['IdEndereco'],
					json_decode($carrinho['Conteudo']),
					$dadosDono
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