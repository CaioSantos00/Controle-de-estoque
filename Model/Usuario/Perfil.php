<?php
	namespace App\Usuario\Perfil;
	use App\Servicos\Conexao\ConexaoBanco as Conn;
	use App\Servicos\Arquivos\PerfilUsuario\Buscar as ImgPerfil;
	use App\Interfaces\Model;
	
	class Perfil implements Model, Stringable{
		private string $idUsuario;
		private array $querysParaChamar;
		
		function __construct(string $cookieIdUsuario){
			$this->idUsuario = hex2bin($cookieIdUsuario);
			$this->querysParaChamar = [
				"select
				`Nome`, `Email`,`Telefone`, `Carrinho`, `TipoConta`
				from `Usuario` where
				`Id` = ?"
			];
		}
		private function getImagemDePerfil() :string{
			$img = new ImgPerfil($this->idUsuario);
			return $img->executar();
		}
		private function getDadosDoBanco(\PDO $conn) :array{
			try{
				$conn->beginTransaction();
				$dados = $conn;
				$dados
					->prepare($this->querysParaChamar[0])
					->execute([$this->idUsuario])
					->fetchAll();
				$conn->commit();
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro('Conexão Perfil',"na busca de dados, {$e->getMessage()}");
				if($conn->inTransaction()) $conn->rollBack();
				$dados = [false];
			}
			catch(\PDOException $e){
				$GLOBALS['ERRO']->setErro('Conexão Perfil',"na busca de dados pro perfil, {$e->getMessage()}");
				if($conn->inTransaction()) $conn->rollBack();
				$dados = [false];
			}
			finally{
				return $dados;
			}
		}
		function __toString(){
			return json_encode($this->getResposta());
		}
		function getResposta() :array{
			return [
				$this->getImagemDePerfil(),
				$this->getDadosDoBanco(Conn::getConexao())
			];
		}
	}