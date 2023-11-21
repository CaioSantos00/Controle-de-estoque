class EnvioDadosUsuario{
	constructor(formulario, botaoDeEnvio, alvo){
		this.xhr = new XMLHttpRequest();
		this.formulario = formulario;
		this.btnEnvio = botaoDeEnvio;
		this.alvo = alvo;

		this.setOuvintesDeEventos();
	}
	setHeaderFoto(){
		this.xhr.setRequestHeader("Content-type", "multipart-formdata")
	}
	setOuvintesDeEventos(){
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
	open(){
		this.xhr.open("POST", `usuario/${this.alvo}`);
	}
	sendForm(){
		this.xhr.send(this.form);
	}
}
