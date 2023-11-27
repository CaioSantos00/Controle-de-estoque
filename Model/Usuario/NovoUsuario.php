<?php
	namespace App\Usuario;

	use App\Interfaces\{Model,ServicoInterno};
	use App\Servicos\Conexao\ConexaoBanco as Conexao;
	use App\Traits\ValidarDadosUsuario as VDUsuario;
	use App\Exceptions\UserException as UException;
	
	class NovoUsuario implements Model, ServicoInterno{
		use VDUsuario;
		private ServicoInterno $imagem;
		private string $idUsuario;
		private array $resposta = [];
		private array $dadosUsuario;
		private string $queryParaExecutar ="
			insert into `Usuario`
			(`Nome`, `Email`, `Senha`, `Telefone`, `TipoConta`)
			values
			(?,?,?,?,?)
		";
		function __construct(ServicoInterno $imagem){
			$this->imagem = $imagem;
		}
		function setDadosUsuario(array $dadosUsuario){
			$dados = [
				$dadosUsuario[0],
				'email' => $dadosUsuario[1],
				$dadosUsuario[2],
				'telefone' => $dadosUsuario[3],
				$dadosUsuario[4]
			];
			$this->validar($dados);
			$this->dadosUsuario = $this->valido
				? array_values($dadosUsuario)
				: [1 => ""];			
		}
		private function enviaParaOBanco(array $dadosUsuario){
			try{
				if(!array_is_list($dadosUsuario)) throw new UException("contém dados errados");
				$queryExec = Conexao::getConexao()->prepare($this->queryParaExecutar);
				$queryExec->execute($dadosUsuario);
				$this->idUsuario = $conexao->lastInsertId();
				$this->resposta["envio"] = "ok";
			}
			catch(UException $e){
				$this->resposta["envio"] = "erro";
				$this->resposta["dadosErrados"] = $this->dadosErrados;
			}			
			catch(\Exception $e){
				$GLOBALS['ERRO']->setErro("Cadastro Usuario", $e->getMessage());
				$this->resposta["envio"] = "erro interno";
			}			
		}
		function executar(){
			$this->enviaParaOBanco($this->dadosUsuarios);
			if($this->resposta["envio"] == "ok"){
				$this->imagem->setIdUsuario($this->idUsuario);
				$this->imagem->executar();
				$this->resposta["imagem"] = $this->imagem->getResposta();
			}
		}
		function getResposta(){
			return $this->resposta;
		}
	}
