	
let camposDados = {
	"nome":	document.getElementById("namePerfil"),
	"email":document.getElementById("emailPerfil"),
	"foto" : document.getElementById("imgPerfil").firstChild
},dadosPerfil;
function populaInputs(dadosPerfil){
	console.log(camposDados.nome.innerText)
	console.log(dadosPerfil.Nome)
	camposDados.nome.innerText = dadosPerfil.Nome
	camposDados.email.innerText = dadosPerfil.Email
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