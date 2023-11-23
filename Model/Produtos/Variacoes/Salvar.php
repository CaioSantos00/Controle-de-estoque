<?php
    namespace App\Produtos\Variacoes;

    use App\Interfaces\Model;
    use App\Servicos\Conexao\ConexaoBanco as CB;
    use App\Servicos\Arquivos\Variacoes\Adicionar;

    class Salvar implements Model{
        private array $dados;
        private string $idVariacao;
        private string $nomeInput;
        private string $query = "insert into `produtosecundario`
        (`ParentId`,`preco/peca`,`qtd`,`Disponibilidade`,`especificacoes`) values
        (:idProduto, :preco, :qtd, :disponivel, :especificacoes)";
        function __construct(array $dados, string $nomeInput){
            $this->dados = $dados;
            $this->nomeInput = $nomeInput;
        }
        private function validarDados() :array|bool{
            $dadosErrados = [];
            $paraMexer =& $this->dados;
            $paraTestar = ['qtd','idProduto','disponivel'];
            array_map('trim', $this->dados);
            array_walk(
                $paraTestar,
                function($valor, $chave) use ($paraMexer, $dadosErrados){
                    if(preg_match('/[^0-9]/', $this->dados[$valor]))
                        $dadosErrados[] = $valor;
                    }
            );
            if(count($this->dados['disponivel']) > 1)
                $dadosErrados[] = "disponivel";
            if(preg_match('/,\d{2}$/', $this->dados['preco']))
                $dadosErrados[] = "preco";
            if(count($dadosErrados) > 0)
                return $dadosErrados;
            return false;
        }
        private function salvarDadosNoBanco(array $dados) :bool{
            try{
                $resultado = true;
                $query = CB::getConexao()->prepare($this->query);
                $query->execute($dados);
                $this->idVariacao = CB::lastInsertId();
                if($query->rowCount() != 1) throw new \Exception("algo deu errado ao inserir");
            }
            catch(\Exception $e){
                $GLOBALS['ERRO']->setErro("salvar dados de variação", $e->getMessage());
                $resultado = false;
            }
            finally{
                return $resultado;
            }
        }
        private function salvarArquivos() :bool{
            $arqv = new Adicionar($this->idVariacao, $this->dados['idProduto']);
            $arqv->nomeInput = $this->nomeInput;
            return $arqv->executar();
        }
        function getResposta(){

        }
    }
