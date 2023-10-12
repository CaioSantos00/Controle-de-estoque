let btnCriaClassi = document.getElementById('criaClassi')
let divHoldClassifi = document.getElementById('divHoldClassifi')
let divHoldVari = document.getElementById('divHoldVari')

function criaClassificacao() {
    let cardsClassificacoes = document.createElement('div')
    cardsClassificacoes.classList.add('cardsClassificacoes')

    let inputsClassi = document.createElement('input')
    inputsClassi.classList.add('inputs')
    inputsClassi.type = 'text'
    //inputsClassi.name = ''

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