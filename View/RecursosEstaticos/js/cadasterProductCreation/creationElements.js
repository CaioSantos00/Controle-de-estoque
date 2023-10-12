let btnCriaClassi = document.getElementById('criaClassi')
let divHoldClassifi = document.getElementById('divHoldClassifi')
let divHoldVari = document.getElementById('divHoldVari')

function criarDiv(){
    let cardsClassificacoes = document.createElement('div')
    cardsClassificacoes.classList.add('cardsClassificacoes')
    return cardsClassificacoes;
}
function criarInput(){
    let inputsClassi = document.createElement('input');
    inputsClassi.classList.add('inputs');
    inputsClassi.type = 'text';

    return inputsClassi;
}
function criarBotaoCancelar(){
    let btnsCancel = document.createElement('button');
    btnsCancel.classList.add('btnsCancel');
    btnsCancel.innerText = 'Cancelar';   

    return btnsCancel;
}
function criarBotaoConfirmar(){
    let btnsConfirm = document.createElement('button');
    btnsConfirm.classList.add('btnsConfirm');
    btnsConfirm.innerText = 'Cancelar';
    return btnsConfirm;
}
function criaClassificacao() {
    let cardsClassificacoes = criarDiv();                
    cardsClassificacoes.append(criarInput(), criarBotaoCancelar(), criarBotaoConfirmar());
    return cardsClassificacoes;        
}

btnCriaClassi.addEventListener('click', () => {
    divHoldClassifi.appendChild(criaClassificacao());
})
