let form = document.getElementById('form'),
	btnEnvio = document.getElementById('btnsForms');
		
let Envio = new EnvioDadosUsuario(form, btnEnvio, "mensagem");
	Envio.xhr.addEventListener("progress", () => {
		console.log("adicionar rodinha girando dizendo que ta carregando/enviando sla");
	})
	Envio.xhr.addEventListener("load", () => {
		//esteja preparado para fazer uma série de avisos a partir das
		//possíveis respostas vindas do back
		
		console.log(Envio.xhr.responseText)
					//To pensando em redirecionar direto pelo php pro index
		console.log("adicionar setinha verdinha dizendo 'enviou certinho' ou coisa do tipo");
	})
	Envio.xhr.addEventListener("error", () => {
		console.log("adicionar Xis vermelho dizendo 'deu errado meu nobre'");
	})