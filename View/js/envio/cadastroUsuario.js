let btnEnvio = document.getElementById('btnsForms');
let formulario=document.getElementById('form');
let mensagensCadaster = document.getElementById('mensagensCadaster')
let qualMensagem = document.getElementById('qualMensagem')
qualMensagem.style.display = 'none'
let Envio = new EnvioDadosUsuario(formulario, btnEnvio, "cadastro");
	Envio.xhr.addEventListener("progress", () => {
		qualMensagem.style.display = 'flex'
		qualMensagem.src = '/estaticos/imgs/loader.gif'
		console.log("adicionar rodinha girando dizendo que ta carregando/enviando sla");
	})
	Envio.xhr.addEventListener("load", () => {
		//esteja preparado para fazer uma série de avisos a partir das
		//possíveis respostas vindas do back
		console.log(Envio.xhr.responseText)		
		formulario.style.display = 'none'
		qualMensagem.src = '/estaticos/imgs/correct.png'
		let linkLogar = document.createElement('a')
		linkLogar.innerText = 'Clique aqui para fazer login'
		linkLogar.href = '/login'
		linkLogar.id = 'aSetinhaBoa'
		mensagensCadaster.appendChild(linkLogar)

		console.log("adicionar setinha verdinha dizendo 'cadastrou certin, confrade' ou coisa do tipo");			
	})
	Envio.xhr.addEventListener("error", () => {
		formulario.style.display = 'none'
		qualMensagem.src = '/estaticos/imgs/incorrect.png'
		let linkLogar = document.createElement('a')
		linkLogar.innerText = 'Clique aqui e tente novamente'
		linkLogar.href = '/cadastro'
		linkLogar.id = 'aSetinhaRuim'
		mensagensCadaster.appendChild(linkLogar)
		console.log("adicionar Xis vermelho dizendo 'deu errado meu nobre'");
	})
	console.log("sdsds");