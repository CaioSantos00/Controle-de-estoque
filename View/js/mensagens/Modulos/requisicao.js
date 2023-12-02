// ESSA É A REQUISIÇÃO DA CONSULTA DE TODAS AS MENSAGENS DE TODOS OS USUÁRIOS
(async () => {
    try{
        let server = await fetch('/envio/consultaMensagens');
        let response = await server.json();
        console.log(response)
    }catch(e){
        console.log("mo fita ne brodi");
    }
})()