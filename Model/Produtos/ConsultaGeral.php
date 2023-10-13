<?php
    namespace App\Produtos;

    use App\Servicos\Arquivos\Produtos\Imgs\ConsultaUnica as CU;
    use App\Interfaces\Model;
    use App\Interfaces\Consulta;
    
    class ConsultaGeral extends Consulta implements Model, \Stringable{        
        function getResposta(){
            return $this->buscarDadosPrincipaisDoBanco(new CU);
        }
        function __toString(){
            return json_encode($this->getResposta());
        }
        function setParametroConsultaPrincipal(){}
    }