<?php
    namespace App\Servicos\Arquivos\PerfilUsuario;
    
    use App\Servicos\Arquivos\UploadsManager;
	use App\Interfaces\ServicoInterno;
	use App\Servicos\Arquivos\PerfilUsuario\Buscar;
	
	class Excluir extends Buscar implements ServicoInterno{
		function __construct(string $idUsuario){
            parent::__construct($idUsuario);
		}
        function executar(){
            $foto = parent::executar();
            if($foto != "") unlink($foto);
        }
    }