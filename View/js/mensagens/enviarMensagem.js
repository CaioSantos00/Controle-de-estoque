	/*eventosRequisicao = {};
	let dados = [
		["motivo",document.getElementsByName('Motivo')[0]],
	    ["conteudo" , document.getElementsByName('Conteudo')[0]],
	    ["imgs" ,document.getElementsByName('imgs[]')[0]]
	];

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
	]*/
	let btnEnvio = document.getElementById('btnsForms'),
    	qualMensagem = document.getElementById('qualMensagem'),
		motivo = document.getElementById('motivo'),
		descricao = document.getElementById('descricao'),
		imgMensagem = document.getElementById('imgMensagem'),
		form = document.getElementById('form'),
		mensagensCadaster = document.getElementById('mensagensCadaster')

		function deuBom() {
			form.style.display = 'none'
				qualMensagem.src = '/estaticos/imgs/correct.png'
				let linkLogar = document.createElement('a')
				linkLogar.innerText = 'Enviado, clique para enviar novamente.'
				linkLogar.href = '/Mensagens'
				linkLogar.id = 'aSetinhaBoa'
				mensagensCadaster.appendChild(linkLogar)
		}

		function deuRuim() {
			form.style.display = 'none'
			qualMensagem.src = '/estaticos/imgs/incorrect.png'
			let linkLogar = document.createElement('a')
			linkLogar.innerText = 'Tente novamente mais tarde.'
			linkLogar.href = '/Mensagens'
			linkLogar.id = 'aSetinhaRuim'
			mensagensCadaster.appendChild(linkLogar)
		}

		qualMensagem.style.display = 'none';

	async function enviarMensagem() {
		let motivoFim = motivo.value.trim()
		let descricaoFinal = descricao.value.trim()
		if (motivoFim == '' || descricaoFinal == '') {
			alert("Preencha todos os campos")
		} else {
		deuBom()
		let formula = new FormData()
		formula.append("Motivo", motivoFim)
		formula.append("Conteudo", descricaoFinal)
		let guarda = imgMensagem.files
		console.log(guarda)
		for (let x = 0; x < guarda.length; x++) {
			formula.append("imgs[]", guarda[x])
		}
		formula.append('Submit', '')
		
		const url = await fetch("/mensagens/enviarMensagem", {
			method: 'POST',
			body: formula
		})
		if (!url.ok) {
            console.log('Erro na requisição')
			deuRuim()
        }
	}}

	btnEnvio.addEventListener('click', async (e) => {
		e.preventDefault();
		enviarMensagem();
	})
