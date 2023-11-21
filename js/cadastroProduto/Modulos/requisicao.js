class Eventos {
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
	console.log(arrayJsons)
	let form = new FormData();
		arrayJsons.forEach((cada) => {
			form.append(cada.chave, cada.valor)
		})
	console.log(form)
	return form;
}
function envia(dados, eventos){
	dados = preparaFormulario(dados);
	let xhr = new XMLHttpRequest();
			xhr.addEventListener("progress",eventos.carregando);
			xhr.addEventListener("load", eventos.carregado);
			xhr.addEventListener("erro", eventos.erro);			
			xhr.open("POST", "/Sistema-de-pedidos-TCC/envio/cadastrarProduto");
			xhr.setRequestHeader("Content-type", "multipart/form-data");
			xhr.send(dados);
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
