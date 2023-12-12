let holdTodosPedidos = document.getElementById('holdTodosPedidos')
let inputBusca = document.getElementById('inputBusca')
let btnBuscaPedido = document.getElementById('btnBuscaPedido')

async function excluirVari(idVari, parentId){
    let form = new FormData();
        form.append("idVariacao", idVari);
        form.append("idProduto", parentId);
    let server = await fetch("/produto/excluirVariacao",{
        method:"POST",
        body: form
    });
    return await server.json();
}
async function buscaVaris(){
    let server = await fetch("/produto/consultarTodos");
    let response = await server.text();
    sessionStorage.setItem("produtos", response);
    return JSON.parse(response);
}
function  criaCardVar(nomeVar, imgSrc, id, produto) {
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
    btnsExcluClass.onclick = () => {
        excluirVari(id,produto )
    }

    let btnsEditClass = document.createElement('button')
    btnsEditClass.classList.add('btnsEditClass')
    btnsEditClass.innerText = 'Editar'
    btnsEditClass.onclick = () => {}

    divEditExclu.append(btnsExcluClass, btnsEditClass)
    cardsVaris.append(nomeVarPes, divImgProdu, divEditExclu)
    holdTodosPedidos.append(cardsVaris)
}
async function buscarImgs(idPrincipal, arrayIdsComFotos){
    let imgs = [], serv;
    if(!arrayIdsComFotos) return false;
    arrayIdsComFotos.forEach(async (cada) => {
        serv = await fetch(`/estaticos/imgs/variacao/${idPrincipal}/${cada}`);
        let response = await serv.json();
        imgs.push(response);
    })
    return imgs.length == 0 ? false : imgs;
}
async function populaContainer(){
    let produtos = await buscaVaris();
    produtos.forEach(async (produto) => {
        let img = await buscarImgs(produto.primarios[0], produto.fotos.Secundarias);
        console.log(img);
        produto.secundarios.forEach((variacao) => {
            let i =  `/estaticos/imgs/variacao/${produto.primarios[0]}/${variacao.Id}/${img[0]}`;
            console.log(i)
            criaCardVar(produto.primarios[1],i, variacao.Id, produto.primarios[0]);
        })
    })
}
populaContainer()
