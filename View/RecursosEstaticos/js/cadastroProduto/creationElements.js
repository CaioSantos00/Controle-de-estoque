function criaClassificacao() {
    let cardsClassificacoes = criaElemento('div', 'cardsClassificacoes')
    let inputsClassi = criaElemento('input', 'inputs')
    	inputsClassi.type = 'text'
    let btnsCancel = criaBtnCancel(divHoldClassifi, cardsClassificacoes)
    let btnsConfirm = criaElemento('button', 'btnsConfirm')
    	btnsConfirm.innerText = 'Confirmar'
    	btnsConfirm.onclick = () => console.log("bah")
    cardsClassificacoes.append(inputsClassi, btnsCancel, btnsConfirm)
    divHoldClassifi.appendChild(cardsClassificacoes)
}

btnCriaClassi.addEventListener('click', () => {
    criaClassificacao()
})

function criaVariacao() {
    let cardsVariacoes = criaElemento('div', 'cardsVariacoes')
    let holdInputs = criaElemento('div', 'holdInputs')
    let inputQtd = criaElemento('input', 'inputVari')
    	inputQtd.type = 'number'
    	inputQtd.min = 1
    	inputQtd.name = ''

    let inputPreco = criaElemento('input', 'inputVari')
    	inputPreco.type = ''
    	inputPreco.name = ''
    let btnsCancel = criaBtnCancel(divHoldVari, cardsVariacoes)
    holdInputs.append(inputQtd, inputPreco, btnsCancel)

    let divTextAreaFile = criaElemento('div', 'divTextAreaFile')
    let variacoesTextArea = criaElemento('textarea', ['inputs', 'variacoesTextArea'])

    let inputFile = criaElemento('input', ['inputFile', 'inputs'])
    	inputFile.type = 'file'
    	inputFile.name = ''
    let buttonConfirm = criaElemento('button', 'btnsConfirm')
    	buttonConfirm.innerText = 'Salvar'

    divTextAreaFile.append(variacoesTextArea, inputFile, buttonConfirm)
    cardsVariacoes.append(holdInputs, divTextAreaFile)
    divHoldVari.appendChild(cardsVariacoes)
}

criaVari.addEventListener('click', () => {
    criaVariacao()
})






/*let btnCriaClassi = document.getElementById('criaClassi')
let divHoldClassifi = document.getElementById('divHoldClassifi')
let divHoldVari = document.getElementById('divHoldVari')
let criaVari = document.getElementById('criaVari')

function criaBtnCancel(divPai ,divQualApagar) {
    let btnsCancel = document.createElement('button')
    btnsCancel.classList.add('btnsCancel')
    btnsCancel.innerText = 'Cancelar'
    btnsCancel.onclick = () => btnCancel(divPai ,divQualApagar)
    return btnsCancel
}

function btnCancel(divPai, apagaDiv) {
    divPai.removeChild(apagaDiv)
}

function criaClassificacao() {
    let cardsClassificacoes = document.createElement('div')
    cardsClassificacoes.classList.add('cardsClassificacoes')

    let inputsClassi = document.createElement('input')
    inputsClassi.classList.add('inputs')
    inputsClassi.type = 'text'
    inputsClassi.name = ''

    let btnsCancel = criaBtnCancel(divHoldClassifi, cardsClassificacoes)

    let btnsConfirm = document.createElement('button')
    btnsConfirm.classList.add('btnsConfirm')
    btnsConfirm.innerText = 'Confirmar'
    cardsClassificacoes.append(inputsClassi, btnsCancel, btnsConfirm)
    divHoldClassifi.appendChild(cardsClassificacoes)
}

btnCriaClassi.addEventListener('click', () => {
    criaClassificacao()
})

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
    divTextAreaFile.append(variacoesTextArea, inputFile, buttonConfirm)
    cardsVariacoes.append(holdInputs, divTextAreaFile)
    divHoldVari.appendChild(cardsVariacoes)
}

criaVari.addEventListener('click', () => {
    criaVariacao()
})*/
