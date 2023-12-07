<?php
    namespace App\Traits;

    trait PadronizarFoto{
        private  $marcaDagua = "ServerInfo/marcaDagua.png";
        private function redimensionaMarcaDagua(){
            $this->marcaDagua = $this->getInterventionImageInstance($this->marcaDagua);
            $this->marcaDagua->resize(50,50);
        }
        private function padronizarFoto($instanciaInterventionImage, $caminhoImg){
            if(is_string($this->marcaDagua)) $this->redimensionaMarcaDagua();
            $img =& $instanciaInterventionImage;
			$img->resize(500,500);
			$img->insert($this->marcaDagua, 'bottom-right', 30, 30);
			$img->save($caminhoImg, 80);
		}
    }
