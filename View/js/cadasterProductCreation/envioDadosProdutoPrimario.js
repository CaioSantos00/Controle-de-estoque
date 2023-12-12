let dom = {
	btnEnviar:document.getElementById("btnsForms"),
	descricao:document.getElementsByName("descricao")[0],
	nome:document.getElementsByName("produto")[0],
	imagens:document.getElementsByName("fotosPrimarias")[0]
};
function recuperaClassificacoesSelecionadas(){
	let todas = document.getElementsByClassName("cardsChecks");
	let qtd = todas.length ?? 0;
	let atual, selecionadas = [];
	for(let x = 0;x != qtd; x++){
		atual = todas[x].firstChild;
		if(atual.checked)
			selecionadas.push(atual.id);
	}
	//faz uma verificação pra mostrar pro usuário que tenq
	//ter pelo menos uma classificação selecionada
	// e passa as validação de caractere especial no input de nome
	return selecionadas;
}
async function enviarDadosPrimarios(dados, fotos){
	let form = new FormData;
	dados.forEach(cada => form.append(...cada));
	// Da o append em todos os dados
	for(let x = 0; x != fotos.length; x++) form.append("fotosPrincipais[]", fotos[x])
	// Da o append em todas as fotos
	let server = await fetch("/produto/salvarPrincipais",{
		method: "POST",
		body: form
	});
	return await server.text();
}

dom.btnEnviar.addEventListener('click', async () => {
	let dados = [
		["Nome", dom.nome.value.trim()],
		["Descricao", dom.descricao.value.trim()],
		["Classificacoes", JSON.stringify(recuperaClassificacoesSelecionadas())]
	];
	await enviarDadosPrimarios(dados,dom.imagens.files);
})
