<?php
    namespace App\Servicos\Arquivos\Produtos\Imgs;

    use App\Servicos\Arquivos\UploadsManager;
    use App\Interfaces\ServicoInterno;

    class Adicionar implements ServicoInterno{
        private string $idProduto;
        private string $idVariacao;
        private $marcaDagua;
        function __construct(string $idVariacao, string $idProduto){
            $this->idProduto = $idProduto;
            $this->idVariacao = $idVariacao;
        }
        private function moveImagem(string $nomeInput){
            $qtdFotos = count($_FILES[$nomeInput]['tmp_name']);
            $caminhoVariacao = "arqvsSecundarios/Produtos/Fotos/{$this->idProduto}/Principais/{$this->idVariacao}/";
			for($x = 0;$x != $qtdFotos;$x++){
				move_uploaded_file(
					$_FILES[$nomeInput]['tmp_name'][$x],
					$caminhoVariacao.$_FILES[$nomeInput]['name'][$x]
				);
				$this->padronizarFoto($caminhoVariacao.$_FILES[$nomeInput]['name'][$x], $this->getInterventionImageInstance());
			}
        }
        function executar(){
            $this->gerarMarcaDagua($this->getInterventionImageInstance());
        }
    }
