<?php
    namespace App\Servicos\Arquivos\PerfilUsuario;
    
    use App\Servicos\Arquivos\PerfilUsuario\Salvar;
	use App\Interfaces\ServicoInterno;
	
    class Editar extends Salvar implements ServicoInterno{
        private string $nomeImagem;
        function __construct(string $idUsuario){
            parent::__construct($idUsuario);
        }
        private function excluirVelha(){
            $imagem = parent::executar();
            if($imagem != '') unlink($imagem);
        }
        function executar() :bool{
            $this->excluirVelha();
            parent::executar();
            $this->getResposta();
        }
    }