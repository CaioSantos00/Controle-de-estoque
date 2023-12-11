let nomeInput = document.getElementById('nome'),
	emailInput = document.getElementById('email'),
	senhaInput = document.getElementById('senha'),
	telefoneInput = document.getElementById('telefone');

function  populaInput(nome, email, senha, telefone) {
	nomeInput.value = nome
	emailInput.value = email
	senhaInput.value = senha
	telefoneInput.value = telefone
}

(async () => {
	try{
		let dados = await fetch("/usuario/perfil");	
		let dadosPerfil = await dados.json();
        console.log(dadosPerfil)
		populaInput(dadosPerfil.Nome, dadosPerfil.Email, "SENHA", dadosPerfil.telefone)
	}catch(e){
		console.log("deu ruim aq");
	}
})()

