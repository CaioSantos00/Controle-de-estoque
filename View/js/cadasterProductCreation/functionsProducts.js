export function criaBtnCancel(divPai ,divQualApagar) {
    let btnsCancel = document.createElement('button')
    btnsCancel.classList.add('btnsCancel')
    btnsCancel.innerText = 'Cancelar'
    btnsCancel.onclick = () => btnCancel(divPai ,divQualApagar)
    return btnsCancel
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