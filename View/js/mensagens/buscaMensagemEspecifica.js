let btnEsquerda = document.getElementById('btnEsquerda'),
    btnDireita = document.getElementById('btnDireita'),
    mudaImg = document.getElementById('mudaImg'),
    fot = document.getElementById('fot'),
    dom = {
        cliente: {
            nome: document.getElementById('nomeCliente'),
            telefone: document.getElementById('telCliente'),
            nroPedido: document.getElementById('numeroPedido'),
            dataPedido: document.getElementById('dataPedido')
        },
        msg:{
            conteudo: document.getElementById('mensagem'),
            motivo: document.getElementById('motivoMsg')
        }
    },
    dadosMsg;


function setEventosCarrosel(){
    let arrayImgs = dadosMsg.imagens
    console.log (arrayImgs)
    if (arrayImgs.length == 0){
        fot.style.display = 'none'
    }
    // ?? ['/estaticos/imgs/amortecedor.jpg', '/estaticos/imgs/amortecedor2.jpg'];
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
    dom.cliente.nome.innerText = dadosMsg.dadosUsuario.Nome;
    dom.cliente.telefone.innerText = dadosMsg.dadosUsuario.telefone;
    dom.cliente.nroPedido.innerText = dadosMsg.idMsg;
    dom.cliente.dataPedido.innerText = dadosMsg.DataEnvio;
    dom.msg.conteudo.innerText = dadosMsg.conteudo.conteudo;
    dom.msg.motivo.innerText = "Motivo: " + dadosMsg.conteudo.motivo
}
async function getMsg(){
    let idMsg = sessionStorage.getItem("msgBusca") ?? "nenhuma";
    let server = await fetch(`/admin/mensagens/infoMsgEspecifica/${idMsg}`);
    dadosMsg = await server.json();
    dadosMsg.dadosUsuario = await (await fetch("/usuario/perfilMensagem")).json();    
    setEventosCarrosel()
    setDadosDom()
    console.log(dadosMsg);
}
getMsg()
