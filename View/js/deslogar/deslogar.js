async function deslogar(){
	// SÓ CHAMAR ESSA FUNÇÃO QUANDO FOR DESLOGAR O USUARIO
	let serv = await fetch("/usuario/logoff");
	let response = await serv.text();
	location.reload();
}