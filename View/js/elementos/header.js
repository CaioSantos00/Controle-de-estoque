async function loadHeader() {
    const resposta = await fetch('http://localhost/Sites/Repositorios/tcc/Sistema-de-pedidos-TCC/View/components/header.html')
    const headerText = await resposta.text()
    const headerContainer = document.querySelector('.header-container');
     headerContainer.innerHTML = headerText;
     let menuHam = document.getElementById('menuHam')
let nav = document.querySelector('nav')

console.log(menuHam)
menuHam.addEventListener('click', ()=> {
    nav.classList.toggle('nav-response')
})
}


loadHeader()