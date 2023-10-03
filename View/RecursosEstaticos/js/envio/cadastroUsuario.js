import EnvioCadastroUsuario from './ClassEnvioCadastroUsuario.js';

let btnEnvio = document.getElementById('btnsForms');
let formulario=document.getElementById('form');

let envio = new EnvioCadastroUsuario(formulario, btnEnvio);
	envio.setOuvintesDeEventos();