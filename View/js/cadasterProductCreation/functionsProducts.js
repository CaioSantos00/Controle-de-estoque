let selectClassi = document.getElementById('selectClassi')

/*export async function diminuiNome(qualStr) {
    qualStr = document.querySelectorAll(`${qualStr}`)
    qualStr.forEach((cadaLetra) => {
        let textoCompleto = cadaLetra.textContent;
        let limiteCaracteres = 20;
    
        if (textoCompleto.length > limiteCaracteres) {
            let textoExibido = textoCompleto.substring(0, limiteCaracteres) + '...';
            cadaLetra.textContent = textoExibido;
        }
    });   
}*/

export function criaBtnCancel(divPai ,divQualApagar) {
    let btnsCancel = document.createElement('button')
    btnsCancel.classList.add('btnsCancel')
    btnsCancel.innerText = 'Cancelar'
    btnsCancel.onclick = () => btnCancel(divPai ,divQualApagar)
    return btnsCancel
}

export async function excluiClassi(classi){
    classi = classi.trim();    
    if(classi == "") return false;
    let serv = await fetch("/envio/excluirClassificacao", {
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
    let classificacoes = await fetch("/envio/consultarClassificacoes")
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

export function transformaMaiusculo(texto) {
    return texto.charAt(0).toUpperCase() + texto.slice(1);
}

(async () => {
    try{
      let opcoes = await consultarClassificacoes();
          opcoes.forEach((e) => {
              selectClassi.append(criaOption(e))     
          });
      console.log(opcoes)
    }
    catch(e){
      console.log(e)
    }
  })()