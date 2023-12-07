import { criaBtnCancel, btnCancel, consultarClassificacoes, criaOption } from "./functionsProducts.js"

let divHoldVari = document.getElementById('divHoldVari');
let criaVari = document.getElementById('criaVari');
let selectProdutoPertenceVariacao = document.getElementById('selectProdutoPertenceVariacao')

let dis = 0;
function criaCheckBoxDisponivel() {
    let checkDispo = document.createElement('input');
    checkDispo.type = "checkbox"
    checkDispo.id = dis;

    let spanCheckDispo = document.createElement('span');
    spanCheckDispo.innerText = "disponivel";

    let labelCheckDispo = document.createElement('label');
    labelCheckDispo.for = dis++;
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
    inputPreco.addEventListener('input', function () {
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

    async function salvaVari() {
        let qtdFim = inputQtd.value.trim()
    let precoFim = inputPreco.value.trim()
    let specsFim = variacoesTextArea.value.trim()
    let idProduto = selectProdutoPertenceVariacao.value;
    
        let form = new FormData()
        form.append('idProduto', idProduto)
        form.append('qtd', qtdFim)
        form.append('preco', precoFim)
        form.append('especificacoes', specsFim)

        console.log(idProduto)

        // Demorei para fazer por conta disso aqui ""labelCheckDispo.checked" e não funcionou
        console.log(labelCheckDispo.checked)
        if (labelCheckDispo.checked) {
            dis = 1
            form.append('disponivel', dis)
        } else {
            dis = 0
           form.append('disponivel', dis)
        }
        
        
        let guardaImg = inputFile.files
        for (let x = 0; x < guardaImg.length; x++) {
            form.append("imgs[]", guardaImg[x])
        }
        form.append('Submit', '')

        const requi = await fetch('/produto/criarDadoSecundario', {
            method: 'POST',
            body: form
        })
        if (!requi.ok) {
            console.log('Erro na requisição')
        }
    }
    

    buttonConfirm.onclick = async () => {
    salvaVari()
    }

    holdInputs.append(labelCheckDispo, inputQtd, inputPreco);
    divTextAreaFile.append(variacoesTextArea, inputFile);
    cardsVariacoes.append(holdInputs, divTextAreaFile, btnsCancel, buttonConfirm);
    divHoldVari.appendChild(cardsVariacoes);
}

criaVari.addEventListener('click', () => criaVariacao());
