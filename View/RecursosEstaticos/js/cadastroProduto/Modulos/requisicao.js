class eventos {
	carregando(e){
		console.log("carregando")
	}
	carregado(e){
		console.group("resposta")
			console.log(e.currentTarget.responseText)
		console.groupEnd()
	}
	erro(e){
		console.log("deu erro")
	}
}
function preparaFormulario(arrayJsons){
	let form = new FormData();
		arrayJsons.forEach((cada) => {
			form.append(cada.chave, cada.valor)
		})
	return form;
}
function envia(dados, eventos){
	let xhr = new XMLHttpRequest();
			xhr.addEventListener("progress",eventos.carregando);
			xhr.addEventListener("load", eventos.carregado);
			xhr.addEventListener("erro", eventos.erro);
			xhr.setRequestHeader("Content-type", "multipart/form-data");
			xhr.open("POST", "/Sistema-de-pedidos-TCC/envio/cadastrarProduto");
			xhr.send(
				preparaFormulario(dados)
			);
}
/*
let ev = new eventos;
	ev.carregado = () => {
	}


 * exemplo de envio
	let form = [
		{
			"chave":"nome",
			"valor":"input.value"
		},{
			"chave":"daquele2",
			"valor":"seu"
		},{
			"chave":"daquele3",
			"valor":"seu"
		}
	]
	envia(form, ev)
*/
