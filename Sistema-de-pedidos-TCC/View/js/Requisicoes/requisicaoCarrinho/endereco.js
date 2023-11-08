const nomeEndereco = document.getElementById('nomeEndereco'),
    telEndereco = document.getElementById('telEndereco'),
    ruaEndereco = document.getElementById('ruaEndereco'),
    numberEndereco = document.getElementById('numberEndereco'),
    bairroEndereco = document.getElementById('bairroEndereco'),
    estadoEndereco = document.getElementById('estadoEndereco'),
    cityEndereco = document.getElementById('cityEndereco'),
    aEdit = document.getElementById('aEdit')

function enviaDadosFront(respostaBusca) {
    try {
        respostaBusca = JSON.parse(respostaBusca)
        sessionStorage.setItem("requisicao", respostaBusca);
        nomeEndereco.innerText = respostaBusca.nome
        telEndereco.innerText = respostaBusca.telefone
        ruaEndereco.innerText = respostaBusca.endereco.rua
        numberEndereco.innerText = respostaBusca.endereco.numero
        bairroEndereco.innerText = respostaBusca.endereco.bairro
        estadoEndereco.innerText = respostaBusca.endereco.estado
        cityEndereco.innerText = respostaBusca.endereco.cidade
    }
    catch (e) {
        console.log(e)
    }
}

async function busca() {
    const resposta = await fetch('http://localhost/Sites/Repositorios/tcc/Sistema-de-pedidos-TCC/View/js/jsonEndereco.json')
    if (!resposta.ok) {
        console.log("Erro de Solicitação !");
        return;
    }
    const respostaBusca = await resposta.text();
    sessionStorage.setItem("requisicao", respostaBusca);
    //console.log(sessionStorage.getItem("requisicao"))
    enviaDadosFront(respostaBusca)
}

busca()
aEdit.addEventListener('click', () => {
    let urlBuscaId = location.href.split('?')
    
    console.log('E')
})