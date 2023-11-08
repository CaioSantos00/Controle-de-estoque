let btnCriaClassi = document.getElementById('criaClassi')
let divHoldClassifi = document.getElementById('divHoldClassifi')
let divHoldVari = document.getElementById('divHoldVari')
let criaVari = document.getElementById('criaVari')

function btnCancel(divPai, apagaDiv) {
    divPai.removeChild(apagaDiv)
}

function criaBtnCancel(divPai ,divQualApagar) {
    let btnsCancel = document.createElement('button')
    btnsCancel.classList.add('btnsCancel')
    btnsCancel.innerText = 'Cancelar'
    btnsCancel.onclick = () => btnCancel(divPai ,divQualApagar)
    return btnsCancel
}
function criaElemento(tag, nameClass) {
    let elemento = document.createElement(tag)
    elemento.classList.add([nameClass])
    return elemento
}
