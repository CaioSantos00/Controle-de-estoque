let selectClassifi = document.getElementById('selectClassifi'),
    classificaFalseTrue = false,
    divChecks = document.getElementById('divChecks')

selectClassifi.addEventListener('click', () => {
    classificaFalseTrue = !classificaFalseTrue
    divChecks.style.display = 'block'
    if (!classificaFalseTrue) {
        divChecks.style.display = 'none'
    }
})