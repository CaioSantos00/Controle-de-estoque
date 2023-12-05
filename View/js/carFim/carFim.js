async function buscaCar() {
    let resposta = await fetch('/carrinho/finalizados')
    if (!resposta.ok) {
        console.log('Erro na requisição')
    }
}