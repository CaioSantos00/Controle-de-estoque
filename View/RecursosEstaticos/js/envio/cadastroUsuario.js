import EnvioDadosUsuario from './ClassEnvioCadastroUsuario.js';

let btnEnvio = document.getElementById('btnsForms');
let formulario=document.getElementById('form');

let Envio = new EnvioDadosUsuario(formulario, btnEnvio, "cadastro");
	
	Envio.xhr.addEventListener("progress", () => {
		console.log("adicionar rodinha girando dizendo que ta carregando/enviando sla");
	})
	Envio.xhr.addEventListener("load", () => {
		//esteja preparado para fazer uma série de avisos a partir das
		//possíveis respostas vindas do back
		console.log(Envio.xhr.responseText)
		console.log("adicionar setinha verdinha dizendo 'cadastrou certin, confrade' ou coisa do tipo");			
	})
	Envio.xhr.addEventListener("error", () => {
		console.log("adicionar Xis vermelho dizendo 'deu errado meu nobre'");
	})