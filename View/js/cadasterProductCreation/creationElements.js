import {criaBtnCancel, btnCancel, consultarClassificacoes, criaOption} from "./functionsProducts.js"

let divHoldVari = document.getElementById('divHoldVari')
let criaVari = document.getElementById('criaVari')

function criaVariacao() {
    let cardsVariacoes = document.createElement('div')
    cardsVariacoes.classList.add('cardsVariacoes')

    let holdInputs = document.createElement('div')
    holdInputs.classList.add('holdInputs')

    let inputQtd = document.createElement('input')
    inputQtd.classList.add('inputVari')
    inputQtd.type = 'number'
    inputQtd.min = 1
    inputQtd.name = ''

    let inputPreco = document.createElement('input')
    inputPreco.type = ''
    inputPreco.name = ''
    inputPreco.classList.add('inputVari')

    let btnsCancel = criaBtnCancel(divHoldVari, cardsVariacoes)
    holdInputs.append(inputQtd, inputPreco, btnsCancel)

    let divTextAreaFile = document.createElement('div')
    divTextAreaFile.classList.add('divTextAreaFile')

    let variacoesTextArea = document.createElement('textarea')
    variacoesTextArea.classList.add('inputs', 'variacoesTextArea')

    let inputFile = document.createElement('input')
    inputFile.classList.add('inputFile', 'inputs')
    inputFile.type = 'file'
    inputFile.name = ''
    
    let buttonConfirm = document.createElement('button')
    buttonConfirm.classList.add('btnsConfirm')
    buttonConfirm.innerText = 'Salvar'
    buttonConfirm.onclick = () => {}

    divTextAreaFile.append(variacoesTextArea, inputFile, buttonConfirm)
    cardsVariacoes.append(holdInputs, divTextAreaFile)
    divHoldVari.appendChild(cardsVariacoes)
}

criaVari.addEventListener('click', () => {
    criaVariacao()
});

async function salvarClassificacao(){

}

async function editarClassificacao(antigo, novo){    
        antigo = antigo.trim()
        novo = novo.trim()
        if(novo == "" || antigo == "") return false;
        let serv = await fetch("/envio/editarClassificacao", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            "paraEditar": antigo,
            "novoValor": novo
        })
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
