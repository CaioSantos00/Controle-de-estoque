<?php
    namespace App\Produtos;

    use App\Servicos\Conexao\ConexaoBanco as CB;
    use App\Traits\OrganizarDadosConsulta as ODC;
    use App\Interfaces\Model;
    use App\Produtos\Variacoes\{
		ConsultaUnica as CUVariacao
	};
    class ConsultaCompra implements Model{
        use ODC;
        private string $idVariacao;
        private string $query = "select `Nome`, `Classificacoes` from `produtoprimario` where `Id` = ?";
        function __construct(string $idVariacao){
            $this->idVariacao = $idVariacao;
        }
        private function getSecundarios() :array{
            return (new CUVariacao($this->idVariacao, [
                "ParentId","preco/peca",
				"qtd","especificacoes"
            ]))->executar();
        }
        private function getPrimarioDele(string $idPrimario) :array|false{
            try {
                $resul = [];
                $query = CB::getConexao()->prepare($this->query);
                $query->execute([$idPrimario]);
                $this->organizar($resul, $query->fetchAll());
                return $resul;
            } catch (\Exception $e) {
                $GLOBALS['ERRO']->setErro("Consulta para Compra", $e->getMessage());
                return false;
            }
        }
        function getResposta(){
            $resuSecunda = $this->getSecundarios();
            $resuPrima = $this->getPrimarioDele($resuSecunda['ParentId'])[0];
            $resuPrima->Classificacoes = json_decode($resuPrima->Classificacoes, true);
            return [$resuPrima,$resuSecunda];
        }
    }
