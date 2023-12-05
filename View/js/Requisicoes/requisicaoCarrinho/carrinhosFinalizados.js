async function buscaCar() {
    let resposta = await fetch('/carrinho/finalizados')
    let response = await resposta.json()
    if (!resposta.ok) {
        console.log('Erro na requisição')
    }
    
    response.forEach(cada => {
        console.log(cada)
        cada.forEach(specsCar => {
            console.log(specsCar.dadosSecundarios)
        })

    });
}

buscaCar()