async function requireError() {
    const buscaResposta = await fetch('arquivoError')
        if (!buscaResposta.ok) {
            console.log("ERRO DE SOLICITAÇÃO")
        }    
        const response = await buscaResposta.text()
        console.log(response)
        let x = response.split("<<<>>>")
        console.log(x)
        x.forEach(elemento => {
            if (elemento != '') {
                console.log(elemento)
                let objeto = JSON.parse(elemento)
                console.log(objeto.quando)
            }
        })
}

requireError()