<?php
    namespace App\Servicos\Arquivos\Variacoes;

    use App\Servicos\Arquivos\UploadsManager;
    use App\Interfaces\ServicoInterno;
    use App\Traits\PadronizarFoto;

    class Adicionar extends UploadsManager implements ServicoInterno{
        use PadronizarFoto;
        private string $idProduto;
        private string $idVariacao;
        function __construct(string $idVariacao, string $idProduto){
            $this->idProduto = $idProduto;
            $this->idVariacao = $idVariacao;
        }
        private function salvarImgs(string $nomeInput){
            $qtdFotos = count($_FILES[$nomeInput]['tmp_name']);
            $caminhoVariacao = "arqvsSecundarios/Produtos/Fotos/{$this->idProduto}/Secundarias/{$this->idVariacao}/";
			for($x = 0;$x != $qtdFotos;$x++){
				move_uploaded_file(
					$_FILES[$nomeInput]['tmp_name'][$x],
					$caminhoVariacao.$_FILES[$nomeInput]['name'][$x]
				);
				$this->padronizarFoto($caminhoVariacao.$_FILES[$nomeInput]['name'][$x], $this->getInterventionImageInstance());
			}
        }
        function executar(){
            try{
                $retorno = true;
                $this->gerarMarcaDagua($this->getInterventionImageInstance());
                $this->salvarImgs();
            }
            catch(\Exception $e){
                $GLOBALS['ERRO']->setErro("Adicionar arquivos a variação específica", $e->getMessage());
                $retorno = false;
            }
            finally{
                return $retorno;
            }
        }
    }
