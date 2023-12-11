let pessoas = [
    {
        nome: 'João da Silva',
        rua: 'Rua A',
        numero: 123,
        bairro: 'Centro',
        cidade: 'Cidade A',
        estado: 'Estado A'
    },
    {
        nome: 'Maria Oliveira',
        rua: 'Rua B',
        numero: 456,
        bairro: 'Bairro X',
        cidade: 'Cidade B',
        estado: 'Estado B'
    },
];

let meusEnd = document.getElementById('meusEnd')

function criaCardEnd(id, nome, rua, numero, bairro, cidade, estado) {
    let cardMyEnd = document.createElement('div')
    cardMyEnd.classList.add('cardMyEnd')

    let infosEnd = document.createElement('div')
    infosEnd.classList.add('infosEnd')

    let holdInfosOne = document.createElement('div')
    holdInfosOne.classList.add('holdInfos')

    let nomePerson = document.createElement('div')
    nomePerson.classList.add('nome')
    nomePerson.innerText = nome + ','
    let ruaPerson = document.createElement('div')
    ruaPerson.classList.add('rua')
    ruaPerson.innerText = rua + ','
    let numberPerson = document.createElement('div')
    numberPerson.innerText = numero + ','

    holdInfosOne.append(nomePerson, ruaPerson, numberPerson)

    let holdInfosTwo = document.createElement('div')
    holdInfosTwo.classList.add('holdInfos')

    let bairroPerson = document.createElement('div')
    bairroPerson.classList.add('bairro')
    bairroPerson.innerText = bairro + ','
    let cidadePerson = document.createElement('div')
    cidadePerson.innerText = cidade + ','
    let statePerson = document.createElement('div')
    statePerson.innerText = estado + '.'

    holdInfosTwo.append(bairroPerson, cidadePerson, statePerson)
    infosEnd.append(holdInfosOne, holdInfosTwo)

    let divBtns = document.createElement('div')
    divBtns.classList.add('divBtns')
    let btnsExcluClass = document.createElement('button')
    btnsExcluClass.classList.add('btnsExcluClass')
    btnsExcluClass.innerText = 'Excluir'
    let arrayExclu = []
    btnsExcluClass.onclick = async () => {
        cardMyEnd.remove()
        arrayExclu.push(id)
        console.log(arrayExclu)
        let form = new FormData();
        form.append("idsEnderecos", JSON.stringify(arrayExclu))
        let resposta = await fetch('/endereco/excluir', {
            method: 'POST',
            body: form
        })
        console.log(resposta)
        console.log(await resposta.text())
        if (!resposta.ok) {
            console.log("Erro na API " + resposta.ok)
        }
    }
    let btnsEditClass = document.createElement('button')
    btnsEditClass.classList.add('btnsEditClass')
    btnsEditClass.innerText = 'Editar'
    btnsEditClass.onclick = () => { }
    divBtns.append(btnsExcluClass, btnsEditClass)

    cardMyEnd.append(infosEnd, divBtns)
    meusEnd.append(cardMyEnd)
}

async function buscaEnds() {
    let resposta = await fetch('/endereco/consultar')
    if (!resposta.ok) {
        console.log("Erro na API " + resposta.ok)
    }
    let respon = await resposta.json()
    console.log(respon)
    if (respon == 'sem enderecos cadastrados') {
        let msg = document.createElement('div')
        msg.innerText = "Sem endereços cadastrados."
        msg.style.textAlign = 'Center'
        meusEnd.append(msg)
        console.log('Sem endereços cadastrados.')
    } else {
    respon.forEach(cada => {
        criaCardEnd(cada.Id, cada.nomeEndereco, cada.Rua, cada.Numero, cada.Bairro, cada.Cidade, cada.Cep)
    });
}
}

buscaEnds()