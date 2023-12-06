async function buscarTodosPrimarios(){
	let server = await fetch("/admin/consulta/consultarProdutosPrimarios");
	return await server.json();
}