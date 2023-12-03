/*let nomeUser = document.getElementById('namePerfil');

    let textoCompleto = nomeUser.textContent;
    let limiteCaracteres = 20;

    if (textoCompleto.length > limiteCaracteres) {
        let textoExibido = textoCompleto.substring(0, limiteCaracteres) + '...';
        nomeUser.textContent = textoExibido;
    }*/

	function diminuiText(elementoPegar, textoFinal) {
		let textoCompleto = elementoPegar.textContent;
    let limiteCaracteres = 17;

    if (textoCompleto.length >= limiteCaracteres) {
		textoCompleto = textoFinal
        let textoExibido = textoCompleto.substring(0, limiteCaracteres) + '...';
		//textoExibido = dadosPerfil.Nome
        elementoPegar.innerText = textoExibido;
    } else {
		elementoPegar.innerText = textoFinal
	}
	}
	
let camposDados = {
	"nome":	document.getElementById("namePerfil"),
	"email":document.getElementById("emailPerfil"),
	"foto" : document.getElementById("imgPerfil").firstChild
},dadosPerfil;
function populaInputs(dadosPerfil){
	diminuiText(camposDados.nome, dadosPerfil.Nome)
	diminuiText(camposDados.email, dadosPerfil.Email)
	/*console.log(camposDados.nome.innerText)
	console.log(dadosPerfil.Nome)
	camposDados.nome.innerText = dadosPerfil.Nome*/
	//camposDados.email.innerText = dadosPerfil.Email
	console.log(dadosPerfil.Email)
	camposDados.foto.src = `/estaticos/fotoPerfilUser/${dadosPerfil.imagem}`;
}
(async (dadosPerfil) => {
	try{
		let dados = await fetch("/usuario/perfil");	
		let resposta = await dados.text();
		dadosPerfil = JSON.parse(resposta);
		populaInputs(dadosPerfil)
	}catch(e){
		console.log("deu ruim aq");
	}
})(dadosPerfil)