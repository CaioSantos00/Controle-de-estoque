(async () => {
	let server = await fetch("/mensagens/minhasMensagens");
	let response = await server.json();
	
	console.log(response)
})()