let motivoMensagem = document.querySelectorAll('.motivoMensagem');

motivoMensagem.forEach(function (cadaLetra) {
    let textoCompleto = cadaLetra.textContent;
    let limiteCaracteres = 20;

    if (textoCompleto.length > limiteCaracteres) {
        let textoExibido = textoCompleto.substring(0, limiteCaracteres) + '...';
        cadaLetra.textContent = textoExibido;
    }
});