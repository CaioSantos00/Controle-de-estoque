<?php
	namespace App\Carrinho;
	
	use App\Servicos\Conexao\ConexaoBanco as CB;
	use App\Interfaces\Model;
	
	class ConsultarFinalizado implements Model{
		private static array $queries = ["select `Nome`, `Telefone`"];
		private static string $query = "SELECT		
		usuario.Nome as NomeUsuario,
		usuario.Telefone as Telefone,
		enderecos.Rua,
		enderecos.Bairro,
		enderecos.Numero as NumeroEndereco,
		enderecos.Cidade,
		carrinhosfinalizados.Data,
		carrinhosfinalizados.Conteudo as ConteudoCarrinho,		
		from usuario inner JOIN enderecos on
		carrinhosfinalizados.IdEndereco = enderecos.Id and
		carrinhosfinalizados.IdDono = usuario.Id and
		carrinhosfinalizados.Id = ?;"
		private static array $finalizados = [];		
		private static function consultar() :bool|array{
			 try{
                $resultado = false;
                $query = CB::getConexao()->prepare($query);
                $query->execute($params);					
				$resultado = $query->fetchAll();
            }catch(\Exception $e){
                $GLOBALS['ERRO']->setErro("Consulta de carrinho finalizado especifico", $e->getMessage());
                $resultado = false;
            }
            finally{
                return $resultado;
            }
		}
		private static function setFinalizado(array $dadosFinalizado, array $parametrosUsados){
			$finalizado = new \stdClass;
			$finalizado->parametros = $parametrosUsados;
			$finalizado->resultados = $dadosFinalizado;
			self::$finalizados[] = $finalizado;
		}
		public static function get(string $idFinalizado){
			if(array_key_exists($idFinalizado, self::$finalizados))
				return self::$finalizados[$idFinalizado];
			self::$finalizados[$idFinalizado] = self::consultar()
		}
	}
	