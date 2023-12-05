let mensagemInput = document.getElementById('mensagemInput'),
    btnBuscaPedido = document.getElementById('btnBuscaPedido'),
    holdTodosPedidos = document.getElementById('holdTodosPedidos')

    async function buscaMensagem() {
    let resposta = await fetch('/envio/consultaMensagens')
    let respon = await resposta.json()
    if (!resposta.ok) {
        console.log("Erro na API " + resposta.ok)
    }
    console.log(respon)
    }

    buscaMensagem()
