let btnCriaClassi = document.getElementById('criaClassi')
let divHoldClassifi = document.getElementById('divHoldClassifi')
let divHoldVari = document.getElementById('divHoldVari')
let criaVari = document.getElementById('criaVari')
let selectClassi = document.getElementById('selectClassi')


function criaBtnCancel(divPai, divQualApagar) {
    let btnsCancel = document.createElement('button')
    btnsCancel.classList.add('btnsCancel')
    btnsCancel.innerText = 'Cancelar'
    btnsCancel.onclick = () => btnCancel(divPai, divQualApagar)
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
    inputsClassi.maxLength = 25
    inputsClassi.addEventListener('input', () => {
        if (inputsClassi.value.length >= 25) alert('Máximo de 30 caracteres')
    })

    let btnsCancel = criaBtnCancel(divHoldClassifi, cardsClassificacoes)

    let btnsConfirm = document.createElement('button')
    btnsConfirm.classList.add('btnsConfirm')
    btnsConfirm.innerText = 'Confirmar'
    btnsConfirm.onclick = async () => {
        let limpaStr = inputsClassi.value.trim()
        if (limpaStr == "") alert('Digite o valor')
        try {
            const urlBusca = await fetch('/envio/cadastrarClassificacao', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({"nome": limpaStr})
            });

            if (!urlBusca.ok) {
                console.log("Erro na solicitação" + urlBusca.status);
            } else {
                alert('Cadastrado');
                selectClassi.append(criaOption(limpaStr));
                cardsClassificacoes.remove();
            }
        } catch (error) {
            console.log(error);
        }

    cardsClassificacoes.append(inputsClassi, btnsCancel, btnsConfirm)
    divHoldClassifi.appendChild(cardsClassificacoes)
    }
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
    buttonConfirm.onclick = () => { }

    divTextAreaFile.append(variacoesTextArea, inputFile, buttonConfirm)
    cardsVariacoes.append(holdInputs, divTextAreaFile)
    divHoldVari.appendChild(cardsVariacoes)
}

criaVari.addEventListener('click', () => {
    criaVariacao()
});

async function consultarClassificacoes() {
    let classificacoes = await fetch("/envio/consultarClassificacoes")
    return await classificacoes.text()
}
async function salvarClassificacao() {

}
function criaOption(valor) {
    let options = document.createElement('option');
    options.value = valor;
    options.innerText = valor;
    return options;
}
async function excluiClassi(classi) {
    classi = classi.trim();
    if (classi == "") return false;
    let serv = await fetch("/envio/excluirClassificacao", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ "paraExcluir": classi })
    });
    let resp = await serv.text() == "tudo certo"
        ? true
        : false;
    if (resp) {
        selectClassi.innerText = "";
        let opcoes = await consultarClassificacoes();
        opcoes = JSON.parse(opcoes);
        opcoes.forEach((e) => {
            selectClassi.append(criaOption(e))
        });
    }
}
async function editarClassificacao(antigo, novo) {
    antigo = antigo.trim()
    novo = novo.trim()
    if (novo == "" || antigo == "") return false;
    let serv = await fetch("/envio/editarClassificacao", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            "paraEditar": antigo,
            "novoValor": novo
        })
    });
    let resp = await serv.text() == "tudo certo"
        ? true
        : false;
    if (resp) {
        selectClassi.innerText = "";
        let opcoes = await consultarClassificacoes();
        opcoes = JSON.parse(opcoes);
        opcoes.forEach((e) => {
            selectClassi.append(criaOption(e))
        });
    }
}
(async () => {
    try {
        let opcoes = await consultarClassificacoes();
        opcoes = JSON.parse(opcoes);
        opcoes.forEach((e) => {
            selectClassi.append(criaOption(e));
        });
        console.log(opcoes);
    }
    catch(e){
        console.log(e);
    }
})()
