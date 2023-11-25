let camposDados = {
	"nome":	document.getElementById("namePerfil"),
	"email":document.getElementById("emailPerfil"),
	"foto" : document.getElementById("imgPerfil").firstChild
},dadosPerfil;
function populaInputs(dadosPerfil){
	camposDados.nome.innerText = dadosPerfil[1][0]
	camposDados.email.innerText = dadosPerfil[1][1]
	camposDados.foto.src = dadosPerfil[0]
}
(async (dadosPerfil) => {	
	let dados = await fetch("/usuario/perfil");	
	let resposta = await dados.text();
	dadosPerfil = JSON.parse(resposta);
	let foto = await fetch(`/estaticos/fotoPerfilUser/${dadosPerfil[0]}`);
	dadosPerfil[0] = await foto.text();
	populaInputs(dadosPerfil)
	console.log(dadosPerfil)	
})(dadosPerfil)