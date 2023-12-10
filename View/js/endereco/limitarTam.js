let rua = document.querySelectorAll('.rua')
let nome = document.querySelectorAll('.nome')
let bairro = document.querySelectorAll('.bairro')
function diminui(nomeVar, qtd) {
    
nomeVar.forEach(function (cadaLetra) {
    let textoCompleto = cadaLetra.textContent;
    let limiteCaracteres = qtd;

    if (textoCompleto.length > limiteCaracteres) {
        let textoExibido = textoCompleto.substring(0, limiteCaracteres) + '...';
        cadaLetra.textContent = textoExibido;
    }
});   
}

diminui(rua, 25)
diminui(nome, 15)
diminui(bairro, 18)