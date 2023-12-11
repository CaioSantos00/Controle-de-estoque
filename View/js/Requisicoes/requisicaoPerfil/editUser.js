(async () => {
	try{
		let dados = await fetch("/usuario/perfil");	
		let dadosPerfil = await dados.json();
        console.log(dadosPerfil)
	}catch(e){
		console.log("deu ruim aq");
	}
})()