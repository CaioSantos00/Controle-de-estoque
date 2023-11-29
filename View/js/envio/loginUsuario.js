let form = document.getElementById('form'),
	btnEnvio = document.getElementById('btnsForms'),
	mensagensCadaster = document.getElementById('mensagensCadaster'),
	qualMensagem = document.getElementById('qualMensagem');
qualMensagem.style.display = 'none'
let Envio = new EnvioDadosUsuario(form, btnEnvio, "login");

Envio.xhr.addEventListener("progress", () => {
	qualMensagem.style.display = 'flex'
	qualMensagem.src = '/estaticos/imgs/loader.gif'
	console.log("adicionar rodinha girando dizendo que ta carregando/enviando sla");
})
Envio.xhr.addEventListener("load", () => {
	//esteja preparado para fazer uma série de avisos a partir das
	//possíveis respostas vindas do back
	console.log(Envio.xhr.responseText)
	switch (Envio.xhr.responseText) {
		case "logou certinho":
			location.href = "home";
			form.style.display = 'none'
			qualMensagem.src = '/estaticos/imgs/correct.png'
			break;
		case "usuario não encontrado":
		form.style.display = 'none'
		qualMensagem.src = '/estaticos/imgs/incorrect.png'
		let linkLogar = document.createElement('a')
		linkLogar.innerText = 'Usuário não encontrado, tente novamente'
		linkLogar.href = '/login'
		linkLogar.id = 'aSetinhaRuim'
		mensagensCadaster.appendChild(linkLogar)
			console.log("sinto lhe dizer amigo");
			break
		default:
			console.log("nada ainda")
	}
	//To pensando em redirecionar direto pelo php pro index
		/*form.style.display = 'none'
		qualMensagem.src = '/estaticos/imgs/correct.png'
	console.log("adicionar setinha verdinha dizendo 'enviou certinho' ou coisa do tipo");*/
})
Envio.xhr.addEventListener("error", () => {
	form.style.display = 'none'
		qualMensagem.src = '/estaticos/imgs/incorrect.png'
		let linkLogar = document.createElement('a')
		linkLogar.innerText = 'Tente novamente'
		linkLogar.href = '/login'
		linkLogar.id = 'aSetinhaRuim'
		mensagensCadaster.appendChild(linkLogar)
	console.log("adicionar Xis vermelho dizendo 'deu errado meu nobre'");
})