let btnEnvio = document.getElementById('btnsForms'),
    qualMensagem = document.getElementById('qualMensagem'),
	form = document.getElementById('form')
	eventosRequisicao = {};
	let dados = [
		["motivo",document.getElementsByName('Motivo')[0]],
	    ["conteudo" , document.getElementsByName('Conteudo')[0]],
	    ["imgs" ,document.getElementsByName('imgs[]')[0]]
	];
	qualMensagem.style.display = 'none';

	eventosRequisicao.progress = [
		"progress", () => {
			qualMensagem.style.display = 'flex'
			qualMensagem.src = '/estaticos/imgs/loader.gif'
			console.log("adicionar rodinha girando dizendo que ta carregando/enviando sla");
		}
	];
	eventosRequisicao.load = [
		"load", () => {
			//esteja preparado para fazer uma série de avisos a partir das
			//possíveis respostas vindas do back
			form.style.display = 'none'
			qualMensagem.src = '/estaticos/imgs/correct.png'
			let linkLogar = document.createElement('a')
			linkLogar.innerText = 'Enviado, clique para enviar novamente.'
			linkLogar.href = '/Mensagens'
			linkLogar.id = 'aSetinhaBoa'
			mensagensCadaster.appendChild(linkLogar)
			console.log(this.xhr.responseText)
						//To pensando em redirecionar direto pelo php pro index
			console.log("adicionar setinha verdinha dizendo 'enviou certinho' ou coisa do tipo");
		}
	];
	eventosRequisicao.erro = [
		"error", () => {
			form.style.display = 'none'
			qualMensagem.src = '/estaticos/imgs/incorrect.png'
			let linkLogar = document.createElement('a')
			linkLogar.innerText = 'Clique aqui e tente novamente'
			linkLogar.href = '/Mensagens'
			linkLogar.id = 'aSetinhaRuim'
			mensagensCadaster.appendChild(linkLogar)
			console.log("adicionar Xis vermelho dizendo 'deu errado meu nobre'");
		}
	]

	async function enviarMensagem(dados){
		this.xhr = new XMLHttpRequest();
		this.form = new FormData();
		this.form.append('Submit', '');
		dados.forEach((cada) => {
			this.form.append(cada[0],cada[1].value ?? cada[1].files);
		});

		this.xhr.open("POST", `mensagens/enviarMensagem`);
		this.xhr.addEventListener(...eventosRequisicao.progress);
		this.xhr.addEventListener(...eventosRequisicao.load);
		this.xhr.addEventListener(...eventosRequisicao.erro);
		this.xhr.setRequestHeader("Content-type", "multipart-formdata");
		this.xhr.send(this.form);
	}
	btnEnvio.addEventListener('click', async (e) => {
		e.preventDefault();
		enviarMensagem();
	})
