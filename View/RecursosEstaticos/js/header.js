async function loadHeader() {
    const resposta = await fetch('../../components/header.html')
    const headerText = await resposta.text()
    const headerElement = document.createElement('div');
    headerElement.innerHTML = headerText;

    const headerContainer = document.querySelector('.header-container');
     headerContainer.appendChild(headerElement);
    console.log(headerText)
}

loadHeader()