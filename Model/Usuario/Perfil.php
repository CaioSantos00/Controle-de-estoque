<?php
	namespace App\Usuario;
	use App\Servicos\Conexao\ConexaoBanco as Conn;
	use App\Servicos\Arquivos\PerfilUsuario\Buscar as ImgPerfil;
	use App\Interfaces\Model;

	class Perfil implements Model, \Stringable{
		private string $idUsuario;
		private array $querysParaChamar = ["select `Nome`, `Email`,`Telefone`, `Carrinho`, `TipoConta` from `Usuario` where `Id` = ?"];

		function __construct(string $cookieIdUsuario, bool $feito = true){
			$this->idUsuario = $feito
				? hex2bin($cookieIdUsuario)
				: $cookieIdUsuario;
		}
		private function getImagemDePerfil() :string{
			$img = (new ImgPerfil($this->idUsuario))->executar();
			return $img != "" ? $img : "imagem não encontrada";
		}
		private function getDadosDoBanco(\PDO $conn) :array|string{
			try{
				$dados = $conn->prepare($this->querysParaChamar[0]);
				$dados->execute([$this->idUsuario]);
				$dados = $dados->fetchAll();
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro('Conexão Perfil',"na busca de dados, {$e->getMessage()}");
				$dados = false;
			}
			catch(\PDOException $e){
				$GLOBALS['ERRO']->setErro('Conexão Perfil',"na busca de dados pro perfil, {$e->getMessage()}");
				$dados = false;
			}
			finally{
				return (is_array($dados) and count($dados) > 0)
					? $dados
					: "perfil não encontrado";
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
