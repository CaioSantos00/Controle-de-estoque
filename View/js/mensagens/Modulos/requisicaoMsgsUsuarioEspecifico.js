let holdTodosPedidos = document.getElementById('holdTodosPedidos'),
    mensagemInput = document.getElementById('mensagemInput'), 
	btnBuscaPedido = document.getElementById('btnBuscaPedido'), 
	msg = document.getElementById('mensagemErro')

function criaCardMyMensagens(motivo, data, status, id) {
	let cardPedido = document.createElement('div')
	cardPedido.classList.add('cardPedido')

	let motivoMensa = document.createElement('div')
	motivoMensa.innerText = "Motivo: " + motivo
	let dataMensa = document.createElement('div')
	dataMensa.innerText = "Data do envio: " + data
	let situacaoPedido = document.createElement('div')
	situacaoPedido.classList.add('situacaoPedido')
	situacaoPedido.innerText = "Status: "
	let statusMensagens = document.createElement('div')
	statusMensagens.classList.add('statusMensagens')
	if(status == "não lida") statusMensagens.innerHTML = '<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="3" cy="3" r="3" transform="matrix(-1 0 0 1 22 2)" stroke="#ff0000" stroke-width="1.5"></circle> <path opacity="0.5" d="M14 2.20004C13.3538 2.06886 12.6849 2 12 2C6.47715 2 2 6.47715 2 12C2 13.5997 2.37562 15.1116 3.04346 16.4525C3.22094 16.8088 3.28001 17.2161 3.17712 17.6006L2.58151 19.8267C2.32295 20.793 3.20701 21.677 4.17335 21.4185L6.39939 20.8229C6.78393 20.72 7.19121 20.7791 7.54753 20.9565C8.88837 21.6244 10.4003 22 12 22C17.5228 22 22 17.5228 22 12C22 11.3151 21.9311 10.6462 21.8 10" stroke="#ff0000" stroke-width="1.5" stroke-linecap="round"></path> </g></svg> Não lida'
    if(status == "lida") statusMensagens.innerHTML = '<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="rgb(0, 194, 0)" stroke-width="1.5"></circle> <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="rgb(0, 194, 0)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg> Lida'
	situacaoPedido.append(statusMensagens)
	let btnVerMais = document.createElement('button')
	btnVerMais.classList.add('btnMaisDetails')
	btnVerMais.innerText = "Ver Mensagem"
		btnVerMais.onclick = () => {
			location.href = "/DetalhesMensagens"
			sessionStorage.setItem('msgBusca', id)
		}
	cardPedido.append(motivoMensa, dataMensa, situacaoPedido, btnVerMais)
	holdTodosPedidos.append(cardPedido)
}

(async () => {
	let server = await fetch("/mensagens/minhasMensagens");
	let response = await server.json();
	if (!server.ok) {
		console.log("Erro na API" + server.ok)
	}
	console.log(response)
	if (!Array.isArray(response)) {
		msg.innerText = "Você não enviou nenhuma mensagem.";
		return
	}	
	msg.innerText = ''	

	response.forEach(cada => {
		criaCardMyMensagens(cada.mensagem.conteudo.motivo, cada.mensagem.DataEnvio, cada.mensagem.Status, cada.mensagem.idMsg)
		console.log()
	});
	console.log(response)
	btnBuscaPedido.addEventListener('click', () => {
        let limpaStr = mensagemInput.value.trim()
		if (limpaStr == '') alert("Preencha todos os campos")
		else {
            holdTodosPedidos.innerHTML = '';
			response.forEach(cada => {					
			if (cada.mensagem.conteudo.motivo == limpaStr.value || cada.mensagem.conteudo.motivo.startsWith(limpaStr)) {
				criaCardMyMensagens(cada.mensagem.conteudo.motivo, cada.mensagem.DataEnvio, cada.mensagem.Status)
			} else alert('Não Encontrado')
			mensagemInput.value = ''
			});
        }

	}) 
})()