<?php
    namespace App\Servicos\Arquivos\Variacoes;

    use App\Interfaces\ServicoInterno;

    class Remover implements ServicoInterno{
        private string $idProduto;
        private string $idVariacao;
        private string $caminhoVariacao = "arqvsSecundarios/Produtos/Fotos/";
        private array $imagens;
        private string $imagem;
        function __construct(string $idVariacao, string $idProduto, string|array $imagens){
            $this->idProduto = $idProduto;
            $this->idVariacao = $idVariacao;
            $this->caminhoVariacao .= "{$this->idProduto}/Secundarias/{$this->idVariacao}";
            switch(true){
                case is_array($imagens):
                    $this->imagens = $imagens;
                    break;
                case is_string($imagens):
                    $this->imagem = $imagens;
                    break;
            }
        }
        private function excluirUm() :bool{
            return unlink($this->caminhoVariacao."/".$this->imagem);
        }
        private function excluirVarios() :bool|array{
            $resultado = [];
            $errados = [];
            foreach($this->imagens as $imagem){
                $resultado[$imagem] = unlink($this->caminhoVariacao."/".$imagem);
            }
            foreach($resultado as $chav => $valor){
                if(!$valor){
                    $errados[] = $chav;
                }
            }
            return count($errados) > 0
                ? $errados
                : true;
        }
        function executar(){
            try{
                $retorno = match(true){
                    empty($this->imagem) => $this->excluirUm(),
                    empty($this->imagens) => $this->excluirVarios(),
                    default => "erro interno"
                };
            }
            catch(\Exception $e){
                $GLOBALS['ERRO']->setErro("remoção de imagem de variação específica", $e->getMessage());
                $retorno = false;
            }
            finally{
                return $retorno;
            }
        }
    }
