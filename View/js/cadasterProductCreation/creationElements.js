import {criaBtnCancel, btnCancel, consultarClassificacoes, criaOption} from "./functionsProducts.js"

let divHoldVari = document.getElementById('divHoldVari');
let criaVari = document.getElementById('criaVari');
let x = 0;

async function enviaVariacao(arrayDadosVariacao, arquivos){
    // deve conter: idProduto, preco, qtd, disponivel, especificacoes
    let form = new FormData;
    arrayDadosVariacao.forEach(cada => form.append(...cada));
    for(let x = 0;x != arquivos.length;x++) form.append("fotosSecundarias[]", arquivos[x]);

    let server = await fetch("/produto/criarDadoSecundario", {
        method: "POST",
        body: form
    })
    console.log(await server.text());
}
function criaCheckBoxDisponivel(){
    let checkDispo = document.createElement('input');
        checkDispo.type ="checkbox"
        checkDispo.id = x;

    let spanCheckDispo = document.createElement('span');
        spanCheckDispo.innerText = "disponivel";

    let labelCheckDispo = document.createElement('label');
        labelCheckDispo.for = x++;
        labelCheckDispo.append(checkDispo, spanCheckDispo);
    return labelCheckDispo;
}
function criaVariacao() {
    let cardsVariacoes = document.createElement('div');
        cardsVariacoes.classList.add('cardsVariacoes');

    let holdInputs = document.createElement('div');
        holdInputs.classList.add('holdInputs');

    let inputQtd = document.createElement('input');
        inputQtd.classList.add('inputVari');
        inputQtd.type = 'number';
        inputQtd.placeholder = 'Qtd';
        inputQtd.min = 1;

    let inputPreco = document.createElement('input');
        inputPreco.placeholder = 'Preço';
        //inputPreco.maxLength = '5';
        inputPreco.classList.add('inputVari');
        inputPreco.addEventListener ('input', function() {
            let valorFinal = inputPreco.value
            valorFinal = valorFinal.replace(/,/g, '')
            valorFinal = valorFinal.replace(/(\d{2})$/, ',$1')
            inputPreco.value = valorFinal
        })

    let labelCheckDispo = criaCheckBoxDisponivel();

    let divTextAreaFile = document.createElement('div');
        divTextAreaFile.classList.add('divTextAreaFile');

    let variacoesTextArea = document.createElement('textarea');
        variacoesTextArea.classList.add('inputs', 'variacoesTextArea');
        variacoesTextArea.placeholder = "Especificações";

    let inputFile = document.createElement('input');
        inputFile.classList.add('inputFileVari', 'inputs');
        inputFile.type = 'file';

    let btnsCancel = criaBtnCancel(divHoldVari, cardsVariacoes);

    let buttonConfirm = document.createElement('button');
        buttonConfirm.classList.add('btnsConfirm');
        buttonConfirm.innerText = 'Salvar';
        buttonConfirm.onclick = async () => {

        }

    holdInputs.append(labelCheckDispo,  inputQtd, inputPreco);
    divTextAreaFile.append(variacoesTextArea, inputFile);
    cardsVariacoes.append(holdInputs, divTextAreaFile, btnsCancel, buttonConfirm);
    divHoldVari.appendChild(cardsVariacoes);
}

criaVari.addEventListener('click', () => criaVariacao());
