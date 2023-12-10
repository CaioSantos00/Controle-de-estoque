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

function criaCardEnd(nome, rua, numero, bairro, cidade, estado) {
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
    btnsExcluClass.onclick = () => {}
    let btnsEditClass = document.createElement('button')
    btnsEditClass.classList.add('btnsEditClass')
    btnsEditClass.innerText = 'Editar'
    btnsEditClass.onclick = () => {}
    divBtns.append(btnsExcluClass, btnsEditClass)

    cardMyEnd.append(infosEnd, divBtns)
    meusEnd.append(cardMyEnd)
}

pessoas.forEach(cada => {
    criaCardEnd(cada.nome, cada.rua, cada.numero, cada.bairro, cada.cidade, cada.estado)
});