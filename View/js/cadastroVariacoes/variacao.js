let selectProdutosPrimarios = document.getElementById("selectProdutoPertenceVariacao");

function criaOption(valor, texto){
	let option = document.createElement("option");
		option.value = valor;
		option.innerText = texto;
	return option;
}
(async () => {
	let server = await fetch("/admin/consulta/consultarProdutosPrimarios");
	let primarios =  await server.json();

	if(!Array.isArray(primarios)){
		alert('Algo deu errado.');
		return;
	}// faz mostrar uma mensagem top aq sla
	primarios.forEach(primario => selectProdutosPrimarios.append(criaOption(primario.Id, primario.Nome)));
})();
