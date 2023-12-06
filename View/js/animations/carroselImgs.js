let btnEsquerda = document.getElementById('btnEsquerda'),
btnDireita = document.getElementById('btnDireita'),
mudaImg = document.getElementById('mudaImg')


let arrayImgs = dadosMsg.imagens ?? ['/estaticos/imgs/amortecedor.jpg', '/estaticos/imgs/amortecedor2.jpg'];
let i = 0
btnDireita.addEventListener('click', ()=> {
    mudaImg.src = arrayImgs[i++]
    if (arrayImgs.length === i) {
        i = 0
    }
})

btnEsquerda.addEventListener('click', ()=> {
    if (i == 0) {
       i = arrayImgs.length - 1
       console.log(i)
    } else {
        i--
    }
    mudaImg.src = arrayImgs[i]
})