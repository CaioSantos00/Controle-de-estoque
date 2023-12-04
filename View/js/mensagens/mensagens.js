let mensagemInput = document.getElementById('mensagemInput'),
    btnBuscaPedido = document.getElementById('btnBuscaPedido'),
    holdTodosPedidos = document.getElementById('holdTodosPedidos')

    async function buscaMensagem() {
    let resposta = await fetch('/consultaMensagens')
    if (!resposta.ok) {
        console.log("Erro na API " + resposta.ok)
    }
    
    }

    buscaMensagem()
