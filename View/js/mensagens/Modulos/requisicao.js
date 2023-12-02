(async () => {
    try{
        let server = await fetch('/envio/consultaMensagens');
        let response = await server.json();
        console.log(response)
    }catch(e){
        console.log("mo fita ne brodi");
    }
})()
