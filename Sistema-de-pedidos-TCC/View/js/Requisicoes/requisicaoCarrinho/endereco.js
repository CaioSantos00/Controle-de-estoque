const nomeEndereco = document.getElementById('nomeEndereco'),
      telEndereco = document.getElementById('telEndereco'),
      ruaEndereco = document.getElementById('ruaEndereco'),
      numberEndereco = document.getElementById('numberEndereco'),
      bairroEndereco = document.getElementById('bairroEndereco'),
      estadoEndereco = document.getElementById('estadoEndereco'),
      cityEndereco = document.getElementById('cityEndereco')

async function loadEndereco() {
    const resposta = await fetch('http://localhost/Sites/Repositorios/tcc/Sistema-de-pedidos-TCC/View/js/jsonEndereco.json')
    if (!resposta.ok) {
        console.log("Erro de Solicitação !")
    }
    try {
    const respostaBusca = await resposta.json()
    nomeEndereco.innerText = respostaBusca.nome
    telEndereco.innerText = respostaBusca.telefone
    ruaEndereco.innerText = respostaBusca.endereco.rua
    numberEndereco.innerText = respostaBusca.endereco.numero
    bairroEndereco.innerText = respostaBusca.endereco.bairro
    estadoEndereco.innerText = respostaBusca.endereco.estado
    cityEndereco.innerText = respostaBusca.endereco.cidade

    //localStorage.setItem("nome", respostaBusca.nome)
    } catch (qualErro){
        console.log('Erro' + qualErro)
    }
}

loadEndereco()