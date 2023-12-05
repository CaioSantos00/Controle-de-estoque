async function deslogar(usuario = false){
	// SÓ CHAMAR ESSA FUNÇÃO QUANDO FOR DESLOGAR O USUARIO
	let serv = await fetch("/usuario/logoff");
	let response = await serv.text();
	if(usuario) location.href = "/home";
	location.reload();
}
/*
	Fiz a função solta pq nn sei se todos os ids de todas as telas
	que tem o btn de deslogar são iguais

	ve lá como q eu fiz no painel de adm
*/
