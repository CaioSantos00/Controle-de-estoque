let form = document.getElementById('form'),
	btnEnvio = document.getElementById('btnsForms'),
    qualMensagem = document.getElementById('qualMensagem'),
	qualMensagem.style.display = 'none',
	eventosRequisicao = {};


	async function prepararRequisicao(){
		this.xhr = new XMLHttpRequest();
		this.form = new FormData(this.formulario);
		this.form.append('Submit', '');
		this.xhr.open("POST", `usuario/${this.alvo}`);
		this.xhr.setRequestHeader("Content-type", "multipart-formdata");
		this.xhr.send(this.form);
	}
	Envio.xhr.addEventListener("progress", () => {
		qualMensagem.style.display = 'flex'
		qualMensagem.src = '/estaticos/imgs/loader.gif'
		console.log("adicionar rodinha girando dizendo que ta carregando/enviando sla");
	})
	Envio.xhr.addEventListener("load", () => {
		//esteja preparado para fazer uma série de avisos a partir das
		//possíveis respostas vindas do back
		form.style.display = 'none'
		qualMensagem.src = '/estaticos/imgs/correct.png'
		let linkLogar = document.createElement('a')
		linkLogar.innerText = 'Enviado, clique para enviar novamente.'
		linkLogar.href = '/Mensagens'
		linkLogar.id = 'aSetinhaBoa'
		mensagensCadaster.appendChild(linkLogar)
		console.log(Envio.xhr.responseText)
					//To pensando em redirecionar direto pelo php pro index
		console.log("adicionar setinha verdinha dizendo 'enviou certinho' ou coisa do tipo");
	})
	Envio.xhr.addEventListener("error", () => {
		form.style.display = 'none'
		qualMensagem.src = '/estaticos/imgs/incorrect.png'
		let linkLogar = document.createElement('a')
		linkLogar.innerText = 'Clique aqui e tente novamente'
		linkLogar.href = '/Mensagens'
		linkLogar.id = 'aSetinhaRuim'
		mensagensCadaster.appendChild(linkLogar)
		console.log("adicionar Xis vermelho dizendo 'deu errado meu nobre'");
	})
