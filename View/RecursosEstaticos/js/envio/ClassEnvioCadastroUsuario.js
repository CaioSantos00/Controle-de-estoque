class EnvioCadastroUsuario{
	constructor(formulario, botaoDeEnvio){
		this.xhr = new XMLHttpRequest();
		this.formulario = formulario;
		this.btnEnvio = botaoDeEnvio;		
	}
	setOuvintesDeEventos(){
		this.xhr.addEventListener("progress", () => {
			console.log("adicionar rodinha girando dizendo que ta carregando/enviando sla");
		})
		this.xhr.addEventListener("load", () => {
			console.log(this.xhr.responseText)
			console.log("adicionar setinha verdinha dizendo 'cadastrou certin, confrade' ou coisa do tipo");
			//esteja preparado para fazer uma série de avisos a partir das
			//possíveis respostas vindas do back
		})
		this.xhr.addEventListener("error", () => {
			console.log("adicionar Xis vermelho dizendo 'deu errado meu nobre'");
		})
		this.btnEnvio.addEventListener("click", (e) => {
			e.preventDefault();
			this.getFormData();
			this.sendForm();
		})
	}
	getFormData(){
		this.form = new FormData(this.formulario);
		this.form.append('Submit', '');
	}
	sendForm(){
		this.xhr.open("POST", "usuario/cadastro");
		this.xhr.send(this.form);
	}
}

export default EnvioCadastroUsuario;