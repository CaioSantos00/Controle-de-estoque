let btnCriaClassi = document.getElementById('criaClassi')
let divHoldClassifi = document.getElementById('divHoldClassifi')
let divHoldVari = document.getElementById('divHoldVari')
let criaVari = document.getElementById('criaVari')

function criaClassificacao() {
    let cardsClassificacoes = document.createElement('div')
    cardsClassificacoes.classList.add('cardsClassificacoes')

    let inputsClassi = document.createElement('input')
    inputsClassi.classList.add('inputs')
    inputsClassi.type = 'text'
    inputsClassi.name = ''

    let btnsCancel = document.createElement('button')
    btnsCancel.classList.add('btnsCancel')
    btnsCancel.innerText = 'Cancelar'

    let btnsConfirm = document.createElement('button')
    btnsConfirm.classList.add('btnsConfirm')
    btnsConfirm.innerText = 'Cancelar'
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
    let btnsCancel = document.createElement('button')
    btnsCancel.classList.add('btnsCancel')
    btnsCancel.innerText = 'Cancelar'
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
})