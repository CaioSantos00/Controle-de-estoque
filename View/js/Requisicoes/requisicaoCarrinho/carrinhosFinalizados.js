let holdCardsPedidos = document.getElementById('holdCardsPedidos')
let numberCompra = 1

/// PEGUEI DO CHAT GPT ESSE ARRAY DE PRODUTOS SÓ PARA TESTAR
let produtos = [
    {
        nome: 'Produto A',
        qtd: 3,
        precoUnitario: 10.00,
        precoTotal: 30.00
    },
    {
        nome: 'Produto B',
        qtd: 2,
        precoUnitario: 15.50,
        precoTotal: 31.00
    }
];

function cards(nomeProduct, qtd, precoUn, precoTo, img) {
    let cardsCar = document.createElement('div')    
    cardsCar.classList.add('cardsCar')

    let infosProductCar = document.createElement('div')
    infosProductCar.classList.add('infosProductCar')

    let imgsCarFim = document.createElement('img')
    imgsCarFim.classList.add('imgsCarFim')
    imgsCarFim.src = img

    let hold = document.createElement('div')

    let nomeProductCarDetails = document.createElement('div')
    nomeProductCarDetails.classList.add('nomeProductCarDetails')
    nomeProductCarDetails.innerText = nomeProduct

    let qtdFimCar = document.createElement('div')
    qtdFimCar.classList.add('qtdFimCar')
    qtdFimCar.innerText = 'Quantidade: ' + qtd

    let precoUni = document.createElement('div')
    precoUni.classList.add('precoCar')
    precoUni.innerText = 'Preço unidade: ' + precoUn

    let precoTotal = document.createElement('div')
    precoTotal.classList.add('precoCar')
    precoTotal.innerText = 'Preço Total: '+ precoTo 

    hold.append(nomeProductCarDetails, qtdFimCar, precoUni, precoTotal)
    infosProductCar.append(imgsCarFim, hold)
    cardsCar.append(infosProductCar)
    return cardsCar;
}

function criaMinhasCompras() {
    let CardsMyPedidos = document.createElement('div')
    CardsMyPedidos.classList.add('CardsMyPedidos')

    let titleDetalhes = document.createElement('div')
    titleDetalhes.classList.add('titleDetalhes')
    titleDetalhes.innerText = 'Compra n° ' + numberCompra++;

    let holdOutrosCards = document.createElement('div')
    holdOutrosCards.classList.add('borderBoxs', 'holdProducts')

    produtos.forEach(cada => {
        let cardsCar = cards(cada.nome, cada.qtd, cada.precoUnitario, cada.precoTotal, '/estaticos/imgs/amortecedor.jpg')    
        holdOutrosCards.append(cardsCar)
    });

    let btnComprar = document.createElement('button')
    btnComprar.classList.add('buyAgain')
    btnComprar.innerText = 'Comprar novamente'
    holdOutrosCards.append(btnComprar)

    CardsMyPedidos.append(titleDetalhes, holdOutrosCards)
    holdCardsPedidos.append(CardsMyPedidos)
}

criaMinhasCompras()
/*

async function buscaCar() {
    let resposta = await fetch('/carrinho/finalizados')
    let response = await resposta.json()
    if (!resposta.ok) {
        console.log('Erro na requisição')
    }
    console.log(response)
        response.forEach(cada => {
        console.log(cada)
        cada.forEach(specsCar => {
            console.log(specsCar.dadosSecundarios)
            
        })

    });
}

buscaCar()
*/