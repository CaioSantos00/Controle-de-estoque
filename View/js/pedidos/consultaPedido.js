let holdTodosPedidos = document.getElementById('holdTodosPedidos')

let pedidos = [
    {
        "Cliente": "Nome do Cliente 1",
        "NumeroPedido": "12345",
        "DataPedido": "2023-12-10",
        "Status": "Pedido Enviado"
    },
    {
        "Cliente": "Nome do Cliente 2",
        "NumeroPedido": "67890",
        "DataPedido": "2023-12-11",
        "Status": "A caminho"
    },
    {
        "Cliente": "Nome do Cliente 3",
        "NumeroPedido": "54321",
        "DataPedido": "2023-12-12",
        "Status": "Pedido Enviado"
    }
]

function criaCardPedido(nome, numeroPedido, data, status) {
    let cardPedido = document.createElement('div')
    cardPedido.classList.add('cardPedido')

    let nomePedi = document.createElement('div')
    nomePedi.innerText = "Cliente: " + nome
    let numeroPedi = document.createElement('div')
    numeroPedi.innerText = "Número do Pedido: " + numeroPedido
    let dataPedi = document.createElement('div')
    dataPedi.innerText = "Data: " + data
    let situacaoPedido = document.createElement('div')
    situacaoPedido.classList.add('situacaoPedido')
    situacaoPedido.innerText = "Status: "

    if (status == "Pedido Enviado") {
        let bolinhaStatusVerde = document.createElement('div')
        bolinhaStatusVerde.classList.add('bolinhaStatusVerde')
        let statusPedidoBom = document.createElement('span')
        statusPedidoBom.innerText = status
        situacaoPedido.append(bolinhaStatusVerde, statusPedidoBom)
    } else if (status == "A caminho") {
        let bolinhaStatusRed = document.createElement('div')
        bolinhaStatusRed.classList.add('bolinhaStatusRed')
        let statusPedidoRuim = document.createElement('span')
        statusPedidoRuim.innerText = status
        situacaoPedido.append(bolinhaStatusRed, statusPedidoRuim)
    }

    let aLink = document.createElement('a')
    let btnMaisDetails = document.createElement('button')
    btnMaisDetails.classList.add('btnMaisDetails')
    btnMaisDetails.innerText = "Mais Detalhes"
    aLink.append(btnMaisDetails)

    cardPedido.append(nomePedi, numeroPedi, dataPedi, situacaoPedido, aLink)
    holdTodosPedidos.append(cardPedido)


}
pedidos.forEach(cada => {

    criaCardPedido(cada.Cliente, cada.NumeroPedido, cada.DataPedido, cada.Status)
})