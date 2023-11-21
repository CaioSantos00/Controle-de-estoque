let btnCriaClassi = document.getElementById('criaClassi');
let divHoldClassifi = document.getElementById('divHoldClassifi');
let divHoldVari = document.getElementById('divHoldVari');
let criaVari = document.getElementById('criaVari');
let selectClassis = document.getElementById('selectClassis');
let nomeProd = document.getElementsByName('nome')[0];
let fotosPrincipaisProd = document.getElementsByName('fotosPrincipais')[0];

function btnCancel(divPai, apagaDiv) {
    divPai.removeChild(apagaDiv);
}

function criaBtnCancel(divPai ,divQualApagar) {
    let btnsCancel = document.createElement('button');
    btnsCancel.classList.add('btnsCancel');
    btnsCancel.innerText = 'Cancelar';
    btnsCancel.onclick = () => btnCancel(divPai ,divQualApagar);
    return btnsCancel;
}
function criaElemento(tag, nameClass) {
    let elemento = document.createElement(tag);
    if(Array.isArray(nameClass)){
      nameClass.forEach((i) => {
        elemento.classList.add(i);
      });
      return elemento;
    }
    elemento.classList.add(nameClass);
    return elemento;
}
