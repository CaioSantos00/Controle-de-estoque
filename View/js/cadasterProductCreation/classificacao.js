import {criaBtnCancel, btnCancel, consultarClassificacoes, criaOption, transformaMaiusculo} from "./functionsProducts.js"

let selectClassi = document.getElementById('selectClassi'),
    btnCriaClassi = document.getElementById('criaClassi'),
    divHoldClassifi = document.getElementById('divHoldClassifi')

function criaClassificacao() {
    let cardsClassificacoes = document.createElement('div')
    cardsClassificacoes.classList.add('cardsClassificacoes')

    let inputsClassi = document.createElement('input')
    inputsClassi.classList.add('inputs')
    inputsClassi.type = 'text'
    inputsClassi.name = ''
    inputsClassi.placeholder = 'Classificação'
    inputsClassi.maxLength = 25
    inputsClassi.addEventListener('input', ()=>{
        if (inputsClassi.value.length >= 25) alert('Máximo de 30 caracteres')
    })

    let btnsCancel = criaBtnCancel(divHoldClassifi, cardsClassificacoes)

    let btnsConfirm = document.createElement('button')
    btnsConfirm.classList.add('btnsConfirm')
    btnsConfirm.innerText = 'Confirmar'
    btnsConfirm.onclick = async () => {
        let limpaStr = inputsClassi.value.trim()
        if (limpaStr == "") alert('Digite o valor')
        if (limpaStr) {
            let newTexto = transformaMaiusculo(limpaStr)
        const urlBusca = await fetch('/envio/cadastrarClassificacao', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({"nome": newTexto})
        }) 
        alert('Cadastrado')
        selectClassi.append(criaOption(newTexto))
        cardsClassificacoes.remove()
        }

    }

    cardsClassificacoes.append(inputsClassi, btnsCancel, btnsConfirm)
    divHoldClassifi.appendChild(cardsClassificacoes)
}

btnCriaClassi.addEventListener('click', () => {
    criaClassificacao()
})


async function excluiClassi(classi){
    classi = classi.trim();    
    if(classi == "") return false;
    let serv = await fetch("/envio/excluirClassificacao", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({"paraExcluir": classi})
    });
    let resp = await serv.text() == "tudo certo"
        ? true
        : false;
    if(resp){
        selectClassi.innerText = "";
        let opcoes = await consultarClassificacoes();
        opcoes = JSON.parse(opcoes);
        opcoes.forEach((e) => {
            selectClassi.append(criaOption(e))     
        });
    }
}

