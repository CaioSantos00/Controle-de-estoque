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
		(`iddono`,  `nomeendereco`, `cep`, `cidade`, `rua`, `bairro`, `numero`,
		`datacriacao`, `instrucoesentrega`, `datamodificacao`)
		values(?,?,?,?,?,?,?,?,?,?)";
		
		function __construct(string $idDono, string $nomeEndereco, array $dadosEndereco){
			$this->idDono = $idDono;
			$this->nomeEndereco = $nomeEndereco;
			$this->dadosEndereco = $dadosEndereco;
			

		}
		private function trataDadosRecebidos() :bool{
            array_walk($this->dadosEndereco,'trim'); //remove espaços em branco envolta de todas as strings

            $dadosErrados = false;
            if(preg_match("/[0-9]{5}-[0-9]{3}/", $this->dadosEndereco["Cep"]) === 0){
                $this->dadosVerificar[] = "Cep";
                $dadosErrados = true;
            }                                

            if(preg_match("/[0-9]+/", $this->dadosEndereco['Cidade']) === 1){

                $this->dadosVerificar[] = "Cidade";                
                $dadosErrados = true;
            }            

            array_walk($this->dadosEndereco, function(&$valor, $index){
                if(preg_match('/[!@#$%^&*()_+{}\[\]:;<>~\\|=]/i', $valor) === 1){

 
                    $this->dadosVerificar[] ="{$valor}";                        
                    $dadosErrados = true;
                    return;
                }
            });  
            return $dadosErrados;
        }
        private function organizaDadosParaEnvio(){
			$this->dadosEndereco = [
				$this->idDono, $this->nomeEndereco,
				$this->dadosEndereco['Cep'],$this->dadosEndereco['Cidade'],
                $this->dadosEndereco['Rua'],$this->dadosEndereco['Bairro'],
				$this->dadosEndereco['Numero'], date("d.m.y \\ g:i"),
				$this->dadosEndereco['InstrucoesEntrega'],date("d.m.y \\ g:i")				
            ];
        }
		private function insereNoBanco() :bool{
            try{                
                $resultado = true;
                $this->organizaDadosParaEnvio();
                CB::getConexao()->beginTransaction();
					$query = CB::getConexao()->prepare($this->query);
				$query->execute($this->dadosEndereco);
				CB::getConexao()->commit();
			}
			catch(\Exception|\PDOException $e){
				CB::voltaTudo();
				$GLOBALS['ERRO']->setErro("cadastro endereco", "{$e->getMessage()} no usuario {$this->idDono}");
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
		function getResposta(){
            if($this->trataDadosRecebidos()){           
                return json_encode($this->dadosVerificar);
            }
            return $this->insereNoBanco(); 
		}
	}
