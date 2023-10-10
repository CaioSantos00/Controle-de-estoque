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
            console.log(elemento)
            JSON.parse(elemento)
        })
}

requireError()