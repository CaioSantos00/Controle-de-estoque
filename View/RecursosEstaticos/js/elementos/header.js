async function loadHeader() {
    const resposta = await fetch('componentes/header')
    const headerText = await resposta.text()
    const headerContainer = document.querySelector('.header-container');
     headerContainer.innerHTML = headerText;
    console.log(headerText)
}

loadHeader()