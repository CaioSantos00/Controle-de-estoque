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
            $this->dados = array_map('trim', $dados);
            $this->nomeInput = $nomeInput;
        }
        private function validarDados() :array|bool{
            $dadosErrados = [];
            $paraTestar = ['qtd','idProduto','disponivel'];
                        
            foreach($paraTestar as $valor)
                if(!is_numeric($this->dados[$valor]))
                    $dadosErrados[] = $valor;
                    
            if(strlen($this->dados['disponivel']) > 1)
                $dadosErrados[] = "disponivel";            
            if(preg_match('/,\d{2}$/', $this->dados['preco']))
                $dadosErrados[] = "preco";
            if(count($dadosErrados) > 0)
                return $dadosErrados;
            return false;
        }
        private function salvarDadosNoBanco(array $dados) :bool{
            try{
                $query = CB::getConexao()->prepare($this->query);
                $query->execute($dados);
                $this->idVariacao = CB::getConexao()->lastInsertId();
                if($query->rowCount() != 1)
                    throw new \Exception("algo deu errado ao inserir");
                return true;
            }
            catch(\Exception $e){
                $GLOBALS['ERRO']->setErro("salvar dados de variação", $e->getMessage());
                return false;
            }
        }
        private function salvarArquivos() :bool{
            $arqv = new Adicionar($this->idVariacao, $this->dados['idProduto']);
            $arqv->nomeInput = $this->nomeInput;
            return $arqv->executar();
        }
        function getResposta(){
            $dadosValidados = $this->validarDados();
            return match(true){
                is_array($dadosValidados) => json_encode($this->dadosValidados),
                $this->salvarDadosNoBanco($this->dados) => $this->salvarArquivos(),                
                default => "erro inesperado"
            };
        }
    }
