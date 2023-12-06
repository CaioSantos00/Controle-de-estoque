
let mensagemInput = document.getElementById('mensagemInput'),
    btnBuscaPedido = document.getElementById('btnBuscaPedido'),
    holdTodosPedidos = document.getElementById('holdTodosPedidos'),
    todasMensagens = '';
    
    function criaCardMensagem(nome, motivo, date, status, idmsg) {
        let cardPedido = document.createElement('div')
        cardPedido.classList.add('cardPedido')
        let nomeDiv = document.createElement('div')
        nomeDiv.innerText = 'Cliente: '
        let spanNome = document.createElement('span')
        spanNome.innerText = nome
        nomeDiv.appendChild(spanNome)
        let motivoMsg = document.createElement('div')
        motivoMsg.innerText = 'Motivo: '
        let spanMotivo = document.createElement('span')
        spanMotivo.innerText = motivo
        motivoMsg.appendChild(spanMotivo)
        let dateDiv = document.createElement('div')
        dateDiv.innerText = 'Data e hora: '
        let spanDate = document.createElement('span')
        spanDate.innerText = date
        dateDiv.appendChild(spanDate)

        let situacaoPedido = document.createElement('div')
        situacaoPedido.classList.add('situacaoPedido')
        situacaoPedido.innerText = 'Status: '
        let statusMensagens = document.createElement('div')
        statusMensagens.classList.add('statusMensagens')
        
        let spanLidaNao = document.createElement('span')
        if (status == 'Lida') {
            spanLidaNao.innerText = 'Lida'
            statusMensagens.innerHTML = `<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="rgb(0, 194, 0)" stroke-width="1.5"></circle> <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="rgb(0, 194, 0)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> g>
        </svg>`
        } else {
            spanLidaNao.innerText = 'Não lida'
            statusMensagens.innerHTML = ` <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="3" cy="3" r="3" transform="matrix(-1 0 0 1 22 2)" stroke="#ff0000" stroke-width="1.5"></circle> <path opacity="0.5" d="M14 2.20004C13.3538 2.06886 12.6849 2 12 2C6.47715 2 2 6.47715 2 12C2 13.5997 2.37562 15.1116 3.04346 16.4525C3.22094 16.8088 3.28001 17.2161 3.17712 17.6006L2.58151 19.8267C2.32295 20.793 3.20701 21.677 4.17335 21.4185L6.39939 20.8229C6.78393 20.72 7.19121 20.7791 7.54753 20.9565C8.88837 21.6244 10.4003 22 12 22C17.5228 22 22 17.5228 22 12C22 11.3151 21.9311 10.6462 21.8 10" stroke="#ff0000" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>`
        }
        situacaoPedido.append(statusMensagens, spanLidaNao)

        let aBtn = document.createElement('a')
            aBtn.href = '/admin/detalhesMensagens'
            aBtn.onclick = () => {
                sessionStorage.setItem("msgBusca", idmsg)
            }
        let btnMaisDetails = document.createElement('button')
            btnMaisDetails.classList.add('btnMaisDetails')
            btnMaisDetails.innerText = 'Ver mensagem'
        
            aBtn.appendChild(btnMaisDetails)
        cardPedido.append(nomeDiv, motivoMsg, dateDiv, situacaoPedido, aBtn)
        holdTodosPedidos.appendChild(cardPedido)
    }

function buscaMensagem(respon, contexto = '') {
        console.log(respon)
        console.log(contexto)
    let strLimpa = mensagemInput.value.trim().toLowerCase();
    let retornou = false    
    holdTodosPedidos.innerHTML = '';    
    respon.forEach(cada => {     
        if (strLimpa === cada.NomeUsuario.toLowerCase() || cada.NomeUsuario.toLowerCase().startsWith(strLimpa)) {
            criaCardMensagem(cada.NomeUsuario, 'Faltou motivo no JSON', cada.DataEnvio, cada.Status, cada.Id)
            retornou = true
            return;
        }
    });
    if(!retornou){
        strLimpa = '';     
        respon.forEach(cada => criaCardMensagem(cada.NomeUsuario, 'Faltou motivo no JSON', cada.DataEnvio, cada.Status, cada.Id));
        alert('Usuário não encontrado')
    }
}

function setTodas(todas){
    todasMensagens = todas;
}
function dividiMensagens(valorInput, funcaoBusca, respon){
    console.log('Passou aqui')
    if (valorInput == '') {
        alert('Preencha o campo')
        return;
    } 
    funcaoBusca(respon, "dividindo mensagens")     
}
    (async () => {
        let resposta = await fetch('/admin/mensagens/consultaMensagens')
        let respon = await resposta.json()
        setTodas(respon)
        if (!resposta.ok) {
            console.log("Erro na API " + resposta.ok)
        }
        buscaMensagem(respon, "consultaInicial")

        btnBuscaPedido.addEventListener('click', ()=> dividiMensagens(mensagemInput.value, buscaMensagem, respon))
                
        mensagemInput.addEventListener('keydown', (e) => {
            if(e.key == "Enter")
                dividiMensagens(mensagemInput.value, buscaMensagem,respon)  
        })
    
    })();