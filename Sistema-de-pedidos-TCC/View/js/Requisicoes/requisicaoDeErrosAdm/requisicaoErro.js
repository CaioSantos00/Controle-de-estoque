let sectionErroAdm = document.getElementById('sectionErroAdm')

function criaElementos(date, local, mensagem) {
    let boxInfoErro = document.createElement('div')
    boxInfoErro.classList.add('boxInfoErro')
    
    let divDateErro = document.createElement('div')
    divDateErro.classList.add('titleInforErro')
    divDateErro.innerText = "Data do erro: "
    let dateError = document.createElement('span')
    dateError.classList.add('inforErro')
    dateError.innerText = date
    divDateErro.append(dateError)

    let divLocalErro = document.createElement('div')
    divLocalErro.classList.add('titleInforErro')  
    divLocalErro.innerText = "Localização do erro: "
    let localErro = document.createElement('span')
    localErro.classList.add('inforErro')
    localErro.innerText = local
    divLocalErro.append(localErro)

    let divMensagemErro = document.createElement('div')
    divMensagemErro.classList.add('titleInforErro')
    divMensagemErro.innerText = "Mensagem do erro: "
    let mensagemErro = document.createElement('span')
    mensagemErro.classList.add('inforErro')
    mensagemErro.innerText = mensagem
    divMensagemErro.append(mensagemErro)

    boxInfoErro.append(divDateErro, divLocalErro, divMensagemErro)
    sectionErroAdm.appendChild(boxInfoErro)
}

async function requireError() {
    const buscaResposta = await fetch('arquivoError')
        if (!buscaResposta.ok) {
            console.log("ERRO DE SOLICITAÇÃO")
        }    
        const response = await buscaResposta.text()
        //console.log(response)
        let x = response.split("<<<>>>")
        //console.log(x)
        x.forEach(elemento => {
            if (elemento != '') {
                let objeto = JSON.parse(elemento)
               /* console.log(objeto.quando)
                console.log(objeto.onde)
                console.log(objeto.Mensagem)*/
                criaElementos(objeto.quando, objeto.onde, objeto.Mensagem)
            }
        })
}

requireError()