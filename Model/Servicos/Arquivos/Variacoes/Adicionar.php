<?php
    namespace App\Servicos\Arquivos\Variacoes;

    use App\Servicos\Arquivos\UploadsManager;
    use App\Interfaces\ServicoInterno;
    use App\Traits\PadronizarFoto;

    class Adicionar extends UploadsManager implements ServicoInterno{
        use PadronizarFoto;
        private string $idProduto;
        private string $idVariacao;
        public string $nomeInput;
        function __construct(string $idVariacao, string $idProduto){
            $this->idProduto = $idProduto;
            $this->idVariacao = $idVariacao;
        }
        private function verificaDiretorio(string $diretorio){
            if(!is_dir($diretorio))
                mkdir($diretorio, 0777, true);
        }
        private function salvarImgs(string $nomeInput){
            $qtdFotos = count($_FILES[$nomeInput]['tmp_name']);
            $caminhoVariacao = "arqvsSecundarios/Produtos/Fotos/{$this->idProduto}/Secundarias/{$this->idVariacao}/";
			for($x = 0;$x != $qtdFotos;$x++){
				move_uploaded_file(
					$_FILES[$nomeInput]['tmp_name'][$x],
					$caminhoVariacao.$_FILES[$nomeInput]['name'][$x]
				);
				$this->padronizarFoto(
                    $this->getInterventionImageInstance($caminhoVariacao.$_FILES[$nomeInput]['name'][$x]),
                    $caminhoVariacao.$_FILES[$nomeInput]['name'][$x]
                );
			}
        }
        function executar(){
            try{
                $this->verificaDiretorio("arqvsSecundarios/Produtos/Fotos/{$this->idProduto}/Secundarias/{$this->idVariacao}");
                $this->salvarImgs($this->nomeInput);
                return true;
            }
            catch(\Exception $e){
                $GLOBALS['ERRO']->setErro("Adicionar arquivos a variação específica", $e->getMessage());
                return false;
            }
        }
    }
