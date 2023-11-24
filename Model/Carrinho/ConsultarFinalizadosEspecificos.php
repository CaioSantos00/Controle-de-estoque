<?php
    namespace App\Carrinho;

    use App\Produtos\Variacoes\ConsultaUnica as CUVariacao;
    use App\Servicos\Arquivos\Variacoes\Consultar as CIVariacao;
    use App\Servicos\Conexao\ConexaoBanco as CB;
    use App\Interfaces\{Model,ServicoInterno};
    use App\Produtos\ConsultaUnica as CUProduto;
    class ConsultarFinalizadosEspecificos implements Model{
        private string $idUsuario;
        private ServicoInterno $buscarImagens;
        private array $dadosParaBuscarDasVariacoes = ["Id","ParentId","preco/peca"];
        private string $query = "select `Id`,`Conteudo`,`Data` from `carrinhosfinalizados` where `IdDono`= :idUsuario";

        function __construct(string $idUsuario){
            $this->idUsuario = $idUsuario;
            $this->buscarImagens = new CIVariacao;
        }
        private function consultarBanco() :bool|array{
            try{
                $resultado = false;
                $query = CB::getConexao()->prepare($this->query);
                $query->execute(["idUsuario" => $this->idUsuario]);
                $resultado = $query->fetchAll();
            }catch(\Exception $e){
                $GLOBALS['ERRO']->setErro("Consulta de carrinho especifico", $e->getMessage());
                $resultado = false;
            }
            finally{
                return $resultado;
            }
        }
        private function organizaConsultaDoBanco(array $consultaBanco) :array{
            $linhasRetorno = [];
            foreach($consultaBanco as $linha){
                $linhasRetorno[] = [
                    "idCarrinho" => $linha["Id"],
                    "Conteudo" => $linha["Conteudo"],
                    "Data" => $linha["Data"]
                ];
            }
            return $linhasRetorno;
        }
        private function buscarImagensDeUmProduto(string $idVariacao, string $idProduto) :array{
            $this->buscarImagens->idProduto = $idProduto;
            $this->buscarImagens->idVariacao = $idVariacao;
            $this->buscarImagens->executar();
            return $this->buscarImagens->ok
            ? $this->buscarImagens->imagens
            : [];
        }
        private function buscarDadosDeUmProdutoDoCarrinho(string $idVariacao) :array{
            $dados = [];
            $dados["dadosSecundarios"] = (new CUVariacao($idVariacao, $this->dadosParaBuscarDasVariacoes))->executar();
            $dados["imagens"] = $this->buscarImagensDeUmProduto($idVariacao, $dados["dadosSecundarios"]["ParentId"]);
            return $dados;
        }
        private function mapearCarrinho(string $conteudoCarrinho) :array{
            $carrinho = json_decode($conteudoCarrinho, true);
            $dadosCarrinho = [];
            foreach($carrinho as $item){
                    $dadosItem = $this->buscarDadosDeUmProdutoDoCarrinho($item["produto"]);
                    $dadosItem["dadosPrimarios"] = (new CUProduto($dadosItem["dadosSecundarios"]["ParentId"]))->getResposta();
                    $dadosCarrinho[] = $dadosItem;
                }
            return $dadosCarrinho;
        }
        function getResposta(){
            $banco = $this->consultarBanco();
            if(!$banco) return false;
            $resposta = [];
            $dadosCarrinhos = $this->organizaConsultaDoBanco($banco);
            foreach($dadosCarrinhos as $dadoCarrinho){
                $resposta[] = $this->mapearCarrinho($dadoCarrinho["Conteudo"]);
            }
            return $resposta;
        }
    }
