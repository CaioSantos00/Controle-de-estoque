<?php
	namespace App\Enderecos;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\Model;
	
	class Cadastrar implements Model{
		private string $idDono;
		private string $nomeEndereco;
        protected array $dadosEndereco;
        public array $dadosVerificar = [];
		private string $query = "insert into `enderecos`
		(`IdDono`,  `nomeEndereco`, `Cep`, `Cidade`, `Rua`, `Bairro`, `Numero`,
		`DataCriacao`, `InstrucoesEntrega`, `dataModificacao`)
		values(?,?,?,?,?,?,?,?,?,?)";
		
		function __construct(string $idDono, string $nomeEndereco, array $dadosEndereco){
			$this->idDono = $idDono;
			$this->nomeEndereco = $nomeEndereco;
			$this->dadosEndereco = $dadosEndereco;
			

		}
		private function trataDadosRecebidos(){
            array_walk($this->dadosEndereco,'trim'); //remove espaços em branco envolta de todas as strings

            if(preg_match("/[0-9]{5}-[0-9]{3}/", $this->dadosEndereco['Cep']) === false){
                $this->dadosVerificar[] = "Cep";
            }                    
            
            if(preg_match("/[0-9]+/", $this->dadosEndereco['Cidade']) === 1){
                $this->dadosVerificar[] = 'Cidade';
            }
            
			$this->dadosEndereco = [
				$this->idDono, $this->nomeEndereco,
				$cep,$cidade,
                $this->dadosEndereco['Rua'],$this->dadosEndereco['Bairro'],
				$this->dadosEndereco['Numero'], date("d.m.y \\ g:i"),
				$this->dadosEndereco['InstrucoesEntrega'],date("d.m.y \\ g:i")				
            ];
            array_walk($this->dadosEndereco, function(&$valor, $index){
                $dado = (preg_match('/[!@#$%^&*()_+{}\[\]:;<>,.?~\\\-|=]/', $valor) === 1)
                    ? ""
                    : $valor;

                $valor = $dado;
            });  
		}
		private function insereNoBanco() :bool{
			try{
				$resultado = false;
				CB::getConexao()->beginTransaction();
					$query = CB::getConexao()->prepare($this->query);
					$resultado = $query->execute($this->dadosEndereco) == 1 ? true : false;
				CB::getConexao()->commit();
			}
			catch(\Exception $e){
				CB::voltaTudo();
				$GLOBALS['ERRO']->setErro("cadastro endereco", $e->getMessage());
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
		function getResposta(){
            $this->trataDadosRecebidos();           
            $retorno = ($this->dadosVerificar != []) 
                ? json_encode($this->dadosVerificar)
                : $this->insereNoBanco();
            return $retorno;
		}
	}
