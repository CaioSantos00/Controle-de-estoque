function separaOsCookies(){
    let coo, cookiesSeparados = [];
    document.cookie.split(";")
        .forEach((cookie, index) =>{
            coo = cookie.split("=");
            cookiesSeparados[coo[0].trim()] = coo[1]
        })
        // o .trim() é pra tirar o espaços em branco
        //em volta da string.
        
        //Só prescisei usar nos indicies dos cookie
    return cookiesSeparados;
}
function transformaLinkParaCarrinho(header){
    let link = header.querySelector('a[href="login"]');
        link.href = "carrinho";
        link.innerText = "Carrinho"
}
function adicionaLinkPainelAdm(header){
    let link = header.querySelector('a[href="carrinho"]');
        link.href = "admin";
        link.innerText = "Admin"
}
function verificaLogin(header){
    let cookies = separaOsCookies();
    if(cookies['login']) transformaLinkParaCarrinho(header)
    if(cookies['TipoConta']) adicionaLinkPainelAdm(header)
}
(async ()=>{
    const resposta = await fetch('componentes/header')
    const headerText = await resposta.text()
    const headerContainer = document.querySelector('.header-container');    
    headerContainer.innerHTML = headerText;
    
    verificaLogin(headerContainer)
})()
