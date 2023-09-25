<?php
	namespace Servicos\Conexao;	
	
	class ConexaoBanco{
		private static PDO $Conexao;
		
		public static function getConexao() :PDO{
			if(empty(ConexaoBanco::Conexao)){								
				try{
					$opcoesDeConexao = [
						'mysql:host=localhost;dbname=mmsx;',
						'root',
						'',
						array(PDO::ATTR_PERSISTENT => TRUE)
					];
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