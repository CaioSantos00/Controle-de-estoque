<?php
	namespace App\Servicos\Arquivos\Produtos\Imgs;
	
	use App\Servicos\Arquivos\UploadsManager;
	use App\Interfaces\ServicoInterno;
	
	class Salvar extends UploadsManager implements ServicoInterno{
		private string $idProduto;
		private string $caminhoDiretorioImgsProduto;
		private array $identificadoresDeVariacoes;
		private $marcaDagua;
		
		function __construct(string $idProduto, array $identificadoresDeVariacoes){
			$this->idProduto = $idProduto;
			$this->identificadoresDeVariacoes = $identificadoresDeVariacoes;			
			$this->caminhoDiretorioImgsProduto =
				"{$this->caminhoArqvsSecundarios}Produtos/Fotos/{$this->idProduto}";
			$this->marcaDagua = $this->getInterventionImageInstance
				("ServerInfo/marcaDagua.png")
				->resize(50,50);
		}
		
		private function criaDiretorioFotosProduto(){		
			mkdir($this->caminhoDiretorioImgsProduto);
			mkdir($this->caminhoDiretorioImgsProduto."/Principais");
			mkdir($this->caminhoDiretorioImgsProduto."/Secundarias");
		}
		private function salvarImagensPrincipais(){
			$qtd = count($_FILES['fotosPrincipais']['tmp_name']);
			for($x = 0; $x != $qtd; $x++){
				move_uploaded_file(
					$_FILES['fotosPrincipais']['tmp_name'][$x],
					$this->caminhoDiretorioImgsProduto."/Principais/".$_FILES['fotosPrincipais']['name'][$x]
				);
			}
		}
		private function salvarImgsDeVariacoes(){
			foreach($this->identificadoresDeVariacoes as $identificador){
				$this->salvarImgsDeVariacaoEspecifica(...$identificador);
			}
		}
		private function salvarImgsDeVariacaoEspecifica(string $idVariacao, string $nroIdentificadorInput){
			$caminhoVariacao = $this->caminhoDiretorioImgsProduto."/Secundarias/".$idVariacao;
			mkdir($caminhoVariacao); //Cria diretório para as imagens para essa variação específica
			$caminhoVariacao .= "/";
			$nomeInput = "fotosSecundarias".$nroIdentificadorInput;
			$qtdFotos = count($_FILES[$nomeInput]['tmp_name']);
		
			for($x = 0;$x != $qtdFotos;$x++){
				move_uploaded_file(
					$_FILES[$nomeInput]['tmp_name'][$x],
					$caminhoVariacao.$_FILES[$nomeInput]['name'][$x]
				);
				$this->padronizarFoto($caminhoVariacao.$_FILES[$nomeInput]['name'][$x]);
			}
		}
		private function padronizarFoto(string $caminhoImg){
			$img = $this->getInterventionImageInstance($caminhoImg);
			$img->resize(350,350);
			$img->insert($this->marcaDagua, 'bottom-right');
			$img->save($caminhoImg, 80, 'jpg');
		}
		function executar(){			
			$this->criaDiretorioFotosProduto();
			$this->salvarImagensPrincipais();
			$this->salvarImgsDeVariacoes();
		}
	}
