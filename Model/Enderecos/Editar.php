<?php
	namespace App\Enderecos;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\Model;
	
	class Editar extends Model{
		private string $idUsuario;
		private string $idEndereco;
		private array $dadosEndereco;
		private array $dadosErrados = [];
		private string $statusDados;
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
		private function testarString(string $teste, string &$variavel){
			if(preg_match($teste,$variavel) === 1)
				$this->dadosErrados[] = $variavel;
		}
		private function preparaParaEnviar() :array|bool{			
			$this->testarString('/[0-9]+/',$this->dadosEndereco['cidade']);
			$this->testarString('/^[0-9]/', $this->dadosEndereco['IdDono']);
			$this->testarString('/^[0-9]/', $this->dadosEndereco['IdEndereco']);
			
			array_walk($this->da-dosEndereco,function(&$valor, $indice){
				$valor = trim($valor);
				$this->testarString('/[!@#$%^&*()_+{}\[\]:;<>~\\|=]/i', $valor);				
			});
			if(count($this->dadosErrados) > 0) return false;		
			return array(
				"nomeEndereco" => $this->dadosEndereco['nome'],
				"Cep" => $this->dadosEndereco['cep'],
				"Cidade" => $this->dadosEndereco['cidade'],
				"Rua" => $this->dadosEndereco['rua'],
				"Bairro" => $this->dadosEndereco['bairro'],
				"Numero" => $this->dadosEndereco['numero'],
				"InstrucoesEntrega" => $this->dadosEndereco['dadosEntrega'],
				"dataModificacao" => date("d.m.y \\ g:i"),
				"IdDono" => $this->dadosEndereco['IdDono'],
				"IdEndereco" => $this->dadosEndereco['IdEndereco']
			);
		}
		private function atualizarNoBanco() :bool{
			try{
				$resultado = true;
				$query = CB::getConexao()->prepare($this->query);
				$dados = $this->preparaParaEnviar();
				if($dados) $query->execute($dados);
				if($query->rowCount() === 0) throw new \Exception("não alterou nada");
			}
			catch(\PDOException $e){
				$GLOBALS['ERRO']->setErro("Edição de endereco", $e->getMessage());
				CB::voltaTudo();
				$resultado = false;
			}
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro("Edição de endereco", $e->getMessage());
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
		function getResposta(){
			return match(true){
				$this->atualizarNoBanco() => true,
				(count($this->dadosErrados) > 0) => json_encode($this->dadosErrados),
				default => false
			};			
		}
	}