<?php
	namespace Controladores\Rotas\RotasUser;
	use Controladores\Rotas\Controlador;

	class RotasUser extends Controlador{
		function __construct(){
			parent::__construct();
		}
		private function prescisaEstarLogado(){
			if(!isset($_COOKIE['login'])) header("location: /login");
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
			$this->prescisaEstarLogado();
			parent::renderizar('pages/telaMensagens.html');
		}
		public function Error($data){
			parent::renderizar('pages/telaErroUser.html');
		}
		public function Carrinho($data){
			$this->prescisaEstarLogado();
			parent::renderizar('pages/carrinho.html');
		}
		public function MinhaConta($data){
			$this->prescisaEstarLogado();
			parent::renderizar('pagesUser/MinhaConta.html');
		}
		public function EditarEndereco($data){
			$this->prescisaEstarLogado();
			parent::renderizar('pages/editarEndereco.html');
		}
		public function MinhasMensagems($data){
			$this->prescisaEstarLogado();
			parent::renderizar('pagesUser/mensagens.html');
		}
		public function DetalhesMensagens($data){
			$this->prescisaEstarLogado();
			parent::renderizar('pagesUser/detailsMensagens.html');
		}
		public function MinhasCompras($data){
			$this->prescisaEstarLogado();
			parent::renderizar('pagesUser/myCompras.html');
		}
		public function MeuPerfil($data){
			$this->prescisaEstarLogado();
			parent::renderizar('pagesUser/painelPerfilUser.html');
		}
		public function FinalCarrinho($data){
			$this->prescisaEstarLogado();
			parent::renderizar('pages/fimCarrinho.html');
		}
		public function visualizarProduto($data){
			parent::renderizar('pages/visualizarProduto.html');
		}
	}
