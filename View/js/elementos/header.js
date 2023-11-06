async function loadHeader() {
    const resposta = await fetch('http://localhost/Sites/Repositorios/tcc/Sistema-de-pedidos-TCC/View/components/header.html')
    const headerText = await resposta.text()
    const headerContainer = document.querySelector('.header-container');
     headerContainer.innerHTML = headerText;
}

loadHeader()