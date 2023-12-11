let btnEsquerda = document.getElementById('btnEsquerda'),
    btnDireita = document.getElementById('btnDireita'),
    mudaImg = document.getElementById('mudaImg'),
    dom = {
        cliente: {
            dataPedido: document.getElementById('dataPedido')
        },
        msg:{
            conteudo: document.getElementById('mensagem'),
            motivo: document.getElementById('motivoMsg')
        }
    },
    dadosMsg;

    
function setEventosCarrosel(){
    let arrayImgs = dadosMsg.imagens ?? ['/estaticos/imgs/amortecedor.jpg', '/estaticos/imgs/amortecedor2.jpg'];
    let i = 0,
        caminhoImgsMsgs = (idMsg, nomeImg) => `/estaticos/imgs/mensagem/${idMsg}/${nomeImg}`;
        //sinta caio, sinta a lambda no JS
    mudaImg.src = caminhoImgsMsgs(dadosMsg.idMsg, arrayImgs[i])
    btnDireita.addEventListener('click', ()=> {
        mudaImg.src = caminhoImgsMsgs(dadosMsg.idMsg, arrayImgs[i++])
        if (arrayImgs.length === i) {
            i = 0
        }
    })    
    btnEsquerda.addEventListener('click', ()=> {
        if (i == 0) {
           i = arrayImgs.length - 1
           return
        } 
        i--
        mudaImg.src = caminhoImgsMsgs(dadosMsg.idMsg, arrayImgs[i])
    })
}
function setDadosDom(){
    dom.cliente.dataPedido.innerText = dadosMsg.DataEnvio;
    dom.msg.conteudo.innerText = dadosMsg.conteudo.conteudo;
    dom.msg.motivo.innerText = dadosMsg.conteudo.motivo
}
async function getMsg(){
    let idMsg = sessionStorage.getItem("msgBusca") ?? "nenhuma";
    let server = await fetch(`/mensagens/minhaMensagem/${idMsg}/sim`);
    dadosMsg = await server.json();
    dadosMsg.dadosUsuario = await (await fetch("/usuario/perfil")).json();    
    setEventosCarrosel()
    setDadosDom()
    console.log(dadosMsg);
}
getMsg()
