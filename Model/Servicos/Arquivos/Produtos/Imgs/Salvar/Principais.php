<?php
	namespace App\Servicos\Arquivos\Produtos\Imgs\Salvar;

	use App\Interfaces\ServicoInterno;

	class Principais implements ServicoInterno{
		const INPUT_ARQVS = "fotosPrincipais";
		private string $dirArqvs = "arqvsSecundarios/Produtos/Fotos/";
		private string $idProduto;
		function setDados(string $idProduto){
			$this->idProduto = $idProduto;
			$this->dirArqvs .= $idProduto;
		}
		private function criaDiretorio(){
			if(!is_dir($this->dirArqvs))
				mkdir($this->dirArqvs);
			$this->dirArqvs .= "/Principais";
			if(!is_dir($this->dirArqvs))
				mkdir($this->dirArqvs);
		}
		private function enviaAoDiretorio(){
			$qtdFotos = count($_FILES[self::INPUT_ARQVS]["tmp_name"]);
			$this->dirArqvs .= "/";

			for($x = 0;$x != $qtdFotos;$x++)
				move_uploaded_file(
					$_FILES[self::INPUT_ARQVS]["tmp_name"][$x],
					$this->dirArqvs.basename($_FILES[self::INPUT_ARQVS]["name"][$x])
				);
		}
		function executar(){
			$this->criaDiretorio();
			$this->enviaAoDiretorio();
		}
	}