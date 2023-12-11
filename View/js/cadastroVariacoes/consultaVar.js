let holdTodosPedidos = document.getElementById('holdTodosPedidos')
let inputBusca = document.getElementById('inputBusca')
let btnBuscaPedido = document.getElementById('btnBuscaPedido')

(async () => {
	let resposta = await fetch('')
})()

function  criaCardVar(nomeVar, imgSrc) {
    let cardsVaris = document.createElement('div')
    cardsVaris.classList.add('cardsVaris')

    let nomeVarPes = document.createElement('div')
    nomeVarPes.classList.add('nomeVar')
    nomeVarPes.innerText = nomeVar

    let divImgProdu = document.createElement('div')
    divImgProdu.classList.add('divImgProdu')
    let imgVar =  document.createElement('img')
    imgVar.src = imgSrc
    divImgProdu.append(imgVar)

    let divEditExclu = document.createElement('div')
    divEditExclu.classList.add('divEditExclu')
    let btnsExcluClass = document.createElement('button')
    btnsExcluClass.classList.add('btnsExcluClass')
    btnsExcluClass.innerText = "Excluir"
    btnsExcluClass.onclick = () => {}

    let btnsEditClass = document.createElement('button')
    btnsEditClass.classList.add('btnsEditClass')
    btnsEditClass.innerText = 'Editar'
    btnsEditClass.onclick = () => {}

    divEditExclu.append(btnsExcluClass, btnsEditClass)
    cardsVaris.append(nomeVarPes, divImgProdu, divEditExclu)
    holdTodosPedidos.append(cardsVaris)
}

