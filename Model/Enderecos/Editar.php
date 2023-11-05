<?php
	namespace App\Enderecos;

	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\Model;

	class Editar implements Model{
		private string $idUsuario;
		private string $idEndereco;
		private array $dadosEndereco;
		private array $dadosErrados = [];
		private string $query = "update `enderecos` set
			`nomeEndereco` = :nomeEndereco,`Cep` = :Cep,`Cidade` = :Cidade,`Rua` = :Rua,
			`Bairro` = :Bairro,`Numero` = :Numero,`InstrucoesEntrega` = :InstrucoesEntrega,
			`dataModificacao` = :dataModificacao
			where `IdDono` = :IdDono and `Id` = :IdEndereco";
		function __construct(string $idUsuario, string $idEndereco, array $dadosEndereco){
			$this->idUsuario = $idUsuario;
			$this->idEndereco = $idEndereco;
			$this->dadosEndereco = $dadosEndereco;
		}
		private function testarString(string $teste, string $variavel, bool $invertido = false){
			$testando = 1;
			if($invertido) $testando = 0;
			if(preg_match($teste,$variavel) === $testando) $this->dadosErrados[] = $variavel;
			return;
		}
		private function validaDadosParaEnvio(){
			$this->testarString('/([0-9]{5}-[0-9]{3})+/', $this->dadosEndereco['cep'], true);
			$this->testarString('/[0-9]+/',$this->dadosEndereco['cidade']);
			$this->testarString('/\D+/', $this->idUsuario);
			$this->testarString('/\D+/', $this->idEndereco);

			foreach($this->dadosEndereco as $indice => $valor){
				$this->dadosEndereco[$indice] = trim($valor);
				$this->testarString('/[!@#$%^&*()_+{}\[\]:;<>~\\|=]/i', $valor);				
			}
			if(count($this->dadosErrados) > 0) throw new \Exception("tem dado errado");
		}
		private function preparaParaEnviar() :array|bool{
			try{
				$this->validaDadosParaEnvio();
				$retorno = [
					"nomeEndereco" => $this->dadosEndereco['nome'],
					"Cep" => $this->dadosEndereco['cep'],
					"Cidade" => $this->dadosEndereco['cidade'],
					"Rua" => $this->dadosEndereco['rua'],
					"Bairro" => $this->dadosEndereco['bairro'],
					"Numero" => $this->dadosEndereco['numero'],
					"InstrucoesEntrega" => $this->dadosEndereco['dadosEntrega'],
					"dataModificacao" => date("d.m.y \\ g:i"),
					"IdDono" => $this->idUsuario,
					"IdEndereco" => $this->idEndereco
				];
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro("Edição de endereco", $e->getMessage());
				$retorno = false;
			}
			finally{
				return $retorno;
			}
		}
		private function atualizarNoBanco() :bool{
			try{
				$query = CB::getConexao()->prepare($this->query);
				$dados = $this->preparaParaEnviar();
				if(is_bool($dados)) throw new \Exception("deu errado na validação");
				$resultado = $query->execute($dados);
				if($query->rowCount() === 0) throw new \Exception("não alterou nada");
			}
			catch(\PDOException $e){
				$GLOBALS['ERRO']->setErro("Edição de endereco PDO", $e->getMessage());
				CB::voltaTudo();
				$resultado = false;
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro("Edição de endereco Normal", $e->getMessage());
				$resultado = false;
			}
			finally{
				$GLOBALS['ERRO']->setErro("edição", $resultado);
				return $resultado;
			}
		}
		function getResposta(){
			if($this->atualizarNoBanco()) return true;
			return (count($this->dadosErrados) > 0) ? $this->dadosErrados : false;
		}
	}