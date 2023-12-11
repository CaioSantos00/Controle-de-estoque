<?php
    namespace App\Carrinho;

    use App\Produtos\Variacoes\ConsultaUnica as CUVariacao;    
    use App\Servicos\Conexao\ConexaoBanco as CB;
    use App\Interfaces\{Model,ServicoInterno};    
    
    class ConsultarFinalizadosEspecificos implements Model{
        private string $idUsuario;
        private ServicoInterno $buscarImagens;
        private Model $buscarEnderecos;        
        private array $querys = [
            "select `Id`,`IdEndereco`,`Conteudo`,`Data` from `carrinhosfinalizados` where `IdDono`= :idUsuario",
            "select produtoprimario.Nome as Nome, produtoprimario.Classificacoes from produtoprimario inner JOIN produtoprimario.Id = produtosecundario.ParentId and produtosecundario.ParentId in (?)"
            "SELECT produtoprimario.Nome as Nome,produtosecundario.`preco/peca` as preco from produtosecundario inner JOIN produtoprimario on produtosecundario.ParentId = produtoprimario.Id and produtosecundario.Id = ?;"
        ];

        function __construct(string $idUsuario, ServicoInterno $buscadorImagens, Model $buscadorEnderecos){
            $this->idUsuario = $idUsuario;
            $this->buscarImagens = $buscadorImagens;
            $this->buscarEnderecos = $buscadorEnderecos;
        }
        private function consultarBanco(string $query, array $parametros) :bool|array{
            try{
                $resultado = false;
                $query = CB::getConexao()->prepare($this->query);
                $query->execute();
                $resultado = $query->fetchAll();
            }catch(\Exception $e){
                $GLOBALS['ERRO']->setErro("Consulta de carrinho especifico", $e->getMessage());
                $resultado = false;
            }
            finally{
                return $resultado;
            }
        }
        private function organizaConsultaDoBanco(array &$consultaBanco){
            $linhasRetorno = [];
            foreach($consultaBanco as $linha)
                $linhasRetorno[] = [
                    "idCarrinho" => $linha["Id"],
                    "IdEndereco" => $linha['IdEndereco'],
                    "Conteudo" => $linha["Conteudo"],
                    "Data" => $linha["Data"]
                ];

            $consultaBanco = $linhasRetorno;
        }
        private function buscarImagensDeUmProduto(string $idVariacao, string $idProduto) :array{
            $this->buscarImagens->idProduto = $idProduto;
            $this->buscarImagens->idVariacao = $idVariacao;
            $this->buscarImagens->executar();
            return $this->buscarImagens->ok
<<<<<<< Updated upstream
            ? $this->buscarImagens->imagens
            : [];
        }
        private function getDadoProduto(array $idVariacao) :array{
            $this;
            return $dadosItem;
        }
        private function getDadosDeTodosOsProdutos(array $carrinho) :array{
            $idsVariacos = array_unique(array_column($carrinho, "produto"));
            foreach ($idsVariacos as $idVariacao){
                print_r($this->getDadoProduto($idVariacao));
            }
            return [$idsVariacos];

=======
                ? $this->buscarImagens->imagens
                : [];
        }        
        private function dadosVariacao(string $idVariacao) :array{
            $dados = $this->consultarBanco($this->querys[1], [$idVariacao]);
>>>>>>> Stashed changes
        }
        private function mapearCarrinho(string $conteudoCarrinho) :array{
            $dadosCarrinho = [];
            $carrinho = json_decode($conteudoCarrinho, true);            
            foreach($carrinho as $item)
                $dadosCarrinho[] = [
                    "produto" => $item["produto"],
                    "dados" => $this->dadosVariacao($item["produto"]),
                    "qtd" => $item['quantidade']
                ];
            
            return $dadosCarrinho;
        }
        function getResposta(){
            $banco = $this->consultarBanco($this->querys[0], ["idUsuario" => $this->idUsuario]);
            if(!$banco) return false;
            $resposta = [];
            $this->organizaConsultaDoBanco($banco);
            foreach($banco as $dadoCarrinho){
                $this->buscarEndereco->setConsulta($dadoCarrinho['IdEndereco'],"Id");
                $resposta[] = [
                    "idCarrinho" => $dadoCarrinho["idCarrinho"],
                    "itensCarrinho" => $this->mapearCarrinho($dadoCarrinho["Conteudo"]),
                    "enderecoEnvio" => $this->buscarEndereco->getResposta(),
                    "dataEnvio" => $dadoCarrinho['Data']
                ];
            }
            return [];// $resposta;
        }
    }
