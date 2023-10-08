<?php
	namespace Controladores\Rotas\RotasAdm;
	use Controladores\Rotas\Controlador;
	
	class RotasAdm extends Controlador{
		function __construct(){
			parent::__construct();
			if(!isset($_COOKIE['TipoConta'])) exit("sai fora, Hacker!");			
		}
		function inicio($data){
			parent::renderizar("pagesAdm/painelPerfilAdm.html");
		}		
	}