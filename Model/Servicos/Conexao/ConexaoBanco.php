<?php
	namespace Servicos\Conexao;	
	
	class ConexaoBanco{
		private static PDO $Conexao;
		
		public static function getConexao() :PDO{
			if(empty(ConexaoBanco::Conexao)){								
				try{					
					$opcoesDeConexao = json_decode(DADOS_CONEXAO_BANCO);
					ConexaoBanco::$Conexao = new PDO(...$opcoesDeConexao);
				}
				catch(PDOException $ex){
					$GLOBALS['ERRO']->setErro('Conexão', $ex->getMessage());
					throw new Exception('Conexao');
				}
				return ConexaoBanco::$Conexao;			
			}
			return ConexaoBanco::$Conexao;
		}
	}
?>