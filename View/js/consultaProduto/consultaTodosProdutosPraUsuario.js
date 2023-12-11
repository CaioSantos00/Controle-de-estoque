async function consultarTodos(){
    let server = await fetch("/produto/consultarTodos");
    let response = await server.json();
    console.log(response)
}
