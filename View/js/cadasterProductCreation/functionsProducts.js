let selectClassi = document.getElementById('selectClassi')
let divChecks = document.getElementById('divChecks')

export function criaBtnCancel(divPai ,divQualApagar) {
    let btnsCancel = document.createElement('button')
    btnsCancel.classList.add('btnsCancel')
    btnsCancel.innerText = 'Cancelar'
    btnsCancel.onclick = () => btnCancel(divPai ,divQualApagar)
    return btnsCancel
}

export async function editarClassificacao(antigo, novo){    
    antigo = antigo.trim()
    novo = novo.trim()
    if(novo == "" || antigo == "") return false;
    let serv = await fetch("/admin/classificacoes/editarClassificacao", {
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
if(resp){
    selectClassi.innerText = "";
    let opcoes = await consultarClassificacoes();
    opcoes = JSON.parse(opcoes);
    opcoes.forEach((e) => {
        selectClassi.append(criaOption(e))     
    });
}
}

export async function excluiClassi(classi){
    classi = classi.trim();    
    if(classi == "") return false;
    let serv = await fetch("/admin/classificacoes/excluirClassificacao", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({"paraExcluir": classi})
    });
    let resp = await serv.text() == "tudo certo"
        ? true
        : false;
    if(resp){
        selectClassi.innerText = "";
        let opcoes = await consultarClassificacoes();
        opcoes = JSON.parse(opcoes);
        opcoes.forEach((e) => {
            selectClassi.append(criaOption(e))     
        });
    }
}

export function btnCancel(divPai, apagaDiv) {
    divPai.removeChild(apagaDiv)
}

export async function consultarClassificacoes(){
    let classificacoes = await fetch("/classificacoes/consultarClassificacoes")
    if(!classificacoes.ok) {
        Error("ERRO NA SOLICITAÇÃO")
    }
    return await classificacoes.json()
}

export function criaOption(valor){
    let options = document.createElement('option');
        options.value = valor;
        options.innerText = valor;
    return options;
}

export function  criaCheckbox(resul) {
    let cardsChecks = document.createElement('div')
    cardsChecks.classList.add('cardsChecks')

    let inputCheck = document.createElement('input')
    inputCheck.type = 'checkbox'
    let limpaStr = resul.trim()
    inputCheck.id = limpaStr
    
    let labelElement = document.createElement('label')
    labelElement.innerText = resul
    labelElement.htmlFor = limpaStr
    cardsChecks.append(inputCheck, labelElement)
    return cardsChecks
    
}

export function transformaMaiusculo(texto) {
    return texto.charAt(0).toUpperCase() + texto.slice(1);
}

(async () => {
    try{
      let opcoes = await consultarClassificacoes();
      console.log(opcoes)
          opcoes.forEach((e) => {
            if (selectClassi) {
                selectClassi.append(criaOption(e))     
            }
            if (divChecks) {
                divChecks.append(criaCheckbox(e))
            }
              
          });
    }
    catch(e){
      console.log(e)
    }
  })()