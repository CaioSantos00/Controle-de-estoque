<?php
    namespace App\Traits;

    trait PadronizarFoto{
        private $marcaDagua;

        private function gerarMarcaDagua($instanciaInterventionImage){
            $this->marcaDagua = $instanciaInterventionImage
                ("ServerInfo/marcaDagua.png")
                ->resize(50,50);
        }
        private function padronizarFoto(string $caminhoImg, $instanciaInterventionImage){
			$img = $instanciaInterventionImage($caminhoImg);
			$img->resize(350,350);
			$img->insert($this->marcaDagua, 'bottom-right');
			$img->save($caminhoImg, 80, 'jpg');
		}
    }
