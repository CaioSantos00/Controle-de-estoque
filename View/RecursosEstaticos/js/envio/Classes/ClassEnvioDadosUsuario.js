class EnvioDadosUsuario{
	constructor(formulario, botaoDeEnvio, alvo){
		this.xhr = new XMLHttpRequest();
		this.formulario = formulario;
		this.btnEnvio = botaoDeEnvio;
		this.alvo = alvo;
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
	sendForm(){
		this.xhr.open("POST", `usuario/${cadastro}`);
		this.xhr.send(this.form);
	}
}

export default EnvioCadastroUsuario;