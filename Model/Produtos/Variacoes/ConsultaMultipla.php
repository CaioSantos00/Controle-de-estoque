<?php
    namespace App\Produtos\Variacoes;

    use App\Servicos\Conexao\ConexaoBanco as CB;
    use App\Interfaces\ServicoInterno;

    class ConsultaMultipla implements ServicoInterno{
        private \PDOStatement $queryPreparada;
        private \stdClass $condicoesQuery;        
        public string $idVariacao;
        private string $queryString = 'select `parentId`, `especificacoes`, `preco/peca`, `qtd` from `produtosecundario` where `Id` = ?';
        function __construct(bool $soDisponiveis = true, bool $getDisponibilidades = false){
            if($soDisponiveis) $this->queryString .= " and `disponibilidade` = 1";
            if($getDisponibilidades) $this->queryString = str_replace("`qtd`","`qtd`,`disponibilidade`", $this->queryString);
            $this->condicoesQuery = new \stdClass;
                $this->condicoesQuery->temQuery = false;
                $this->condicoesQuery->tentouInstanciar = false;
        }
        private function preparaQuery(bool $disponiveis = true, bool $getDisponiveis = false){
            try{
                if($this->condicoesQuery->tentouInstanciar) return;
                
                CB::getConexao()->beginTransaction();
                    $query = CB::getConexao()->prepare($this->queryString);
                    if(is_bool($query)) throw new \Exception("falhou quando foi preparar query");
                    $this->queryPreparada = $query;
                    $this->condicoesQuery->temQuery = true;
                CB::getConexao()->commit();
            }
            catch(\Exception|\PDOException $e){
                $GLOBALS['ERRO']->setErro("consulta multipla", $e->getMessage());
                $this->condicoesQuery->tentouInstanciar = true;
                throw new \Exception("não preparou a query");
            }
        }
        function executar(){
            try{
                $dados = false;
                if(!$this->condicoesQuery->temQuery) $this->preparaQuery();
                $this->queryPreparada->execute([$this->idVariacao]);
                $dados = $this->queryPreparada->fetchAll();
            }
            catch(\Exception|\PDOException $e){
                $GLOBALS['ERRO']->setErro("consulta multipla", $e->getMessage());
                CB::voltaTudo();
                $dados = false;
            }
            finally{
                return $dados;
            }
        }
    }