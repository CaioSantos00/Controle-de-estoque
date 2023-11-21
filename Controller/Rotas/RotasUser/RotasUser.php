<?php
	namespace Controladores\Rotas\RotasUser;	
	use Controladores\Rotas\Controlador;	
	
	class RotasUser extends Controlador{		
		
		function __construct(){
			parent::__construct();	
		}		
		public function home($data){
			parent::renderizar('pages/inicio.html');
		}
		public function login($data){
			parent::renderizar('pages/login.html');
		}
		public function sobre($data){
			parent::renderizar('pages/sobre.html');
		}
		public function produtos($data){
			parent::renderizar('pages/produtos.html');
		}
		public function cadastro($data){
			parent::renderizar('pages/cadastro.html');
		}
		public function telaMsgs($data){
			parent::renderizar('pages/telaMensagens.html');
		}
		public function Error($data){
			parent::renderizar('pages/telaErroUser.html');
		}
		public function Carrinho($data){
			parent::renderizar('pages/carrinho.html');
		}
		
		public function EditarEndereco($data){
			parent::renderizar('pages/editarEndereco.html');
		}
		public function MinhasMensagems($data){
			parent::renderizar('pagesUser/mensagens.html');
		}
		public function FinalCarrinho($data){
			parent::renderizar('pages/fimCarrinho.html');
		}
		public function visualizarProduto($data){
			parent::renderizar('pages/visualizarProduto.html');
		}
	}