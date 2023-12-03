let dom = {
	btnEnviar:document.getElementById("btnsForms"),
	descricao:document.getElementsByName("descricao")[0],
	nome:document.getElementsByName("produto")[0],
	imagens:document.getElementsByName("fotosPrimarias")[0]
};

dom.btnEnviar.addEventListener('click', () => {
	sessionStorage.setItem('dados',JSON.stringify({
		nome: dom.nome.value.trim(),
		descricao: dom.descricao.value.trim(),
	}))
})
