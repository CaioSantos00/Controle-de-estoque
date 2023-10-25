let divDescription = document.getElementById('divDescription'),
    descriptionProduct = document.getElementById('descriptionProduct'),
    descriptionProductFalseTrue = false
 
divDescription.addEventListener('click', () => {
    descriptionProductFalseTrue = !descriptionProductFalseTrue
    descriptionProduct.style.display = 'flex'
    if (!descriptionProductFalseTrue) {
        descriptionProduct.style.display = 'none'
    }
})

