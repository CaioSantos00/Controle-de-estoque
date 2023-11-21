let btnEsquerda = document.getElementById('btnEsquerda'),
btnDireita = document.getElementById('btnDireita'),
mudaImg = document.getElementById('mudaImg')


let arrayImgs = ['../imgs/amortece.webp', '../imgs/amortecedor.jpg', '../imgs/amortecedor2.jpg']
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