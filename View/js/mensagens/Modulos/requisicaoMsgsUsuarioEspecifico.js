(async () => {
	let server = await fetch("/usuario/minhasMensagens");
	let response = await server.json();
	
	console.log(response)
})()