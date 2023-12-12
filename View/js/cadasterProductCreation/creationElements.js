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
    return [checkDispo,labelCheckDispo];
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
        inputPreco.classList.add('inputVari');
        inputPreco.addEventListener('input', function () {
            inputPreco.value = inputPreco.value
                .replace(/,/g, '')
                .replace(/(\d{2})$/, ',$1');
        })

    let [checkDispo,labelCheckDispo] = criaCheckBoxDisponivel();

    let divTextAreaFile = document.createElement('div');
        divTextAreaFile.classList.add('divTextAreaFile');

    let variacoesTextArea = document.createElement('textarea');
        variacoesTextArea.classList.add('inputs', 'variacoesTextArea');
        variacoesTextArea.placeholder = "Especificações";

    let inputFile = document.createElement('input');
        inputFile.classList.add('inputFileVari', 'inputs');
        inputFile.type = 'file';
        inputFile.multiple = true;

    let btnsCancel = criaBtnCancel(divHoldVari, cardsVariacoes);

    let buttonConfirm = document.createElement('button');
        buttonConfirm.classList.add('btnsConfirm');
        buttonConfirm.innerText = 'Salvar';

    async function salvaVari(){
        let qtdFim = inputQtd.value.trim();
        let precoFim = inputPreco.value.trim();
        let specsFim = variacoesTextArea.value.trim();
        let idProduto = selectProdutoPertenceVariacao.value;
        let guardaImg = inputFile.files, qtd = guardaImg.length;
        console.log(guardaImg);
        let form = new FormData();
            form.append('idProduto', idProduto);
            form.append('qtd', qtdFim);
            form.append('preco', precoFim);
            form.append('especificacoes', specsFim);
            form.append("disponivel", (checkDispo.checked ? 1 : 0));
            form.append('Submit', '');

        for(let x = 0; x < qtd; x++)
            form.append("fotosSecundarias[]", guardaImg[x]);


        const requi = await fetch('/produto/criarDadoSecundario', {
            method: 'POST',
            body: form
        });
        alert('Produto enviado com sucesso')
        const response = await requi.json();
        if(Array.isArray(response)){
            console.log("dados errados")
            console.log(response)
        }
    }


    buttonConfirm.onclick = async () => {
        if(selectProdutoPertenceVariacao.value != "nn tem"){
            await salvaVari();
            cardsVariacoes.remove();
            return;
        }
        let antes = selectProdutoPertenceVariacao.style.backgroundColor;
        selectProdutoPertenceVariacao.style.backgroundColor = "red";
        setTimeout(() => {
            selectProdutoPertenceVariacao.style.backgroundColor = antes;
        }, 500)
    }

    holdInputs.append(labelCheckDispo, inputQtd, inputPreco);
    divTextAreaFile.append(variacoesTextArea, inputFile);
    cardsVariacoes.append(holdInputs, divTextAreaFile, btnsCancel, buttonConfirm);
    divHoldVari.appendChild(cardsVariacoes);
}

criaVari.addEventListener('click', () => criaVariacao());
