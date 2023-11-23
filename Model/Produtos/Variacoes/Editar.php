<?php
    namespace App\Produtos\Variacoes;

    use App\Servicos\Conexao\ConexaoBanco as CB;
    use App\Interfaces\Model;
    use App\Exceptions\UserException;

    class Editar implements Model{
        private string $idVariacao;
        private array $novosDados;
        private string $query = "update `produtosecundario` set
            `preco/peca` = :preco,
            `qtd` = :qtd,
            `Disponibilidade` = :ok,
            `especificacoes` = :especificacoes
            where `Id` = :id";
        function __construct(string $idVariacao, array $novosDados){
            $this->idVariacao = $idVariacao;
            $this->novosDados = $novosDados;
        }
        private function sanitizaDados() :array|bool{
            $errados = [];
            $this->novosDados = array_map('trim', $this->novosDados);
            if(!preg_match("/\D+/",$this->novosDados['qtd'])) $errados[] = 'qtd';
            if(!preg_match("/\D+/",$this->novosDados['ok'])) $errados[] = 'ok';
            return count($errados) > 0
                ? $errados
                : false;
        }
        private function editarNoBanco(array $dados) :bool{
            try{
                $resultado = true;
                CB::getConexao()->beginTransaction();
                    $query = CB::getConexao()->prepare($this->query);
                    if($query->execute($dados + ["id" => $this->idVariacao])) throw new \Exception("não executou");
                    if($query->rowCount() == 0) throw new UserException("não alterou nenhum");

                CB::getConexao()->commit();
            }
            catch(UserException $e){
                CB::voltaTudo();
                $resultado = false;
            }
            catch(\Exception|\PDOException $e){
                CB::voltaTudo();
                $resultado = false;
                $GLOBALS['ERRO']->setErro("Edição de variação", $e->getMessage());
            }
            finally{
                return $resultado;
            }
        }
        function getResposta(){
            $dados = $this->sanitizaDados()
            return is_bool($dados)
                ? $this->editarNoBanco($dados)
                : $dados;
        }
    }
