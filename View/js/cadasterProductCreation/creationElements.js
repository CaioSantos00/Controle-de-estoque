import {criaBtnCancel, btnCancel, consultarClassificacoes, criaOption} from "./functionsProducts.js"

let divHoldVari = document.getElementById('divHoldVari')
let criaVari = document.getElementById('criaVari')

async function enviaVariacao(arrayDadosVariacao, arquivos){
    // deve conter: idProduto, preco, qtd, disponivel, especificacoes
    let form = new FormData;
    arrayDadosVariacao.forEach(cada => form.append(...cada));
    for(let x = 0;x != arquivos.length;x++) form.append("fotosSecundarias[]");
    
    let server = await fetch("/produto/criarDadoSecundario", {
        method: "POST",
        body: form
    })
    console.log(await server.text());
}
function criaVariacao() {
    let cardsVariacoes = document.createElement('div')
        cardsVariacoes.classList.add('cardsVariacoes')

    let holdInputs = document.createElement('div')
        holdInputs.classList.add('holdInputs')

    let inputNomeVar = document.createElement('input')
        inputNomeVar.classList.add('inputVari')
        inputNomeVar.placeholder = 'Nome da Variação'

    let inputQtd = document.createElement('input')
        inputQtd.classList.add('inputVari')
        inputQtd.type = 'number'
        inputQtd.placeholder = 'Qtd'
        inputQtd.min = 1
        inputQtd.name = ''

    let inputPreco = document.createElement('input')
        inputPreco.type = ''
        inputPreco.name = ''
        inputPreco.placeholder = 'Preço'
        inputPreco.classList.add('inputVari')

    
    let divTextAreaFile = document.createElement('div')
        divTextAreaFile.classList.add('divTextAreaFile')
    
    let variacoesTextArea = document.createElement('textarea')
        variacoesTextArea.classList.add('inputs', 'variacoesTextArea')
    
    let inputFile = document.createElement('input')
        inputFile.classList.add('inputFileVari', 'inputs')
        inputFile.type = 'file'
        inputFile.name = ''
        
    let btnsCancel = criaBtnCancel(divHoldVari, cardsVariacoes)
    let buttonConfirm = document.createElement('button')
        buttonConfirm.classList.add('btnsConfirm')
        buttonConfirm.innerText = 'Salvar'
        buttonConfirm.onclick = async () => {
            
        }

    holdInputs.append(inputNomeVar, inputQtd, inputPreco)
    divTextAreaFile.append(variacoesTextArea, inputFile)
    cardsVariacoes.append(holdInputs, divTextAreaFile, btnsCancel, buttonConfirm)
    divHoldVari.appendChild(cardsVariacoes)
}

criaVari.addEventListener('click', () => {
    criaVariacao()
});


