let form = document.getElementById('form'),
	btnEnvio = document.getElementById('btnsForms');
	
let Envio = new EnvioDadosUsuario(form, btnEnvio, "login");

	Envio.xhr.addEventListener("progress", () => {
		console.log("adicionar rodinha girando dizendo que ta carregando/enviando sla");
	})
	Envio.xhr.addEventListener("load", () => {
		//esteja preparado para fazer uma série de avisos a partir das
		//possíveis respostas vindas do back
		
		//To pensando em redirecionar direto pelo php pro index
		console.log(Envio.xhr.responseText)
		console.log("adicionar setinha verdinha dizendo 'cadastrou certin, confrade' ou coisa do tipo");			
	})
	Envio.xhr.addEventListener("error", () => {
		console.log("adicionar Xis vermelho dizendo 'deu errado meu nobre'");
	})