let divDescription = document.getElementById('divDescription'),
    descriptionProduct = document.getElementById('descriptionProduct'),
    descriptionProductFalseTrue = false,
    divChecks = document.getElementById('divChecks'),
    selectClassifi = document.getElementById('selectClassifi'),
    selectVaria = document.getElementById('selectVaria'),
    divChecksVar = document.getElementById('divChecksVar')

/*divDescription.addEventListener('click', () => {
    descriptionProductFalseTrue = !descriptionProductFalseTrue
    descriptionProduct.style.display = 'flex'
    if (!descriptionProductFalseTrue) {
        descriptionProduct.style.display = 'none'
    }
})*/

function abreEfecha(divPai, divEscondida) {
    divPai.addEventListener('click', () => {
        descriptionProductFalseTrue = !descriptionProductFalseTrue
        divEscondida.style.display = 'block'
        if (!descriptionProductFalseTrue) {
            divEscondida.style.display = 'none'
        }
    })
}
(() =>{
    if (divDescription && descriptionProduct) {
        abreEfecha(divDescription, descriptionProduct)
        return
    }
    console.log('Elemento não existe')
})()

abreEfecha(selectClassifi, divChecks)
abreEfecha(selectVaria, divChecksVar)
