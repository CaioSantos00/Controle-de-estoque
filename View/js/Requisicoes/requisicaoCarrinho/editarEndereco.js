/*let nomeGuardado = localStorage.getItem("nome")
console.log(nomeGuardado)*/
let nomeCompleto = document.getElementById('nomeCompleto'),
    telefone = document.getElementById('telefone'),
    estado = document.getElementById('estado'),
    cidade = document.getElementById('cidade'),
    bairro = document.getElementById('bairro'),
    cep = document.getElementById('cep'),
    rua = document.getElementById('rua'),
    numero = document.getElementById('numero'),
    btnSalvarEndere = document.getElementById('btnSalvarEndere');

function enviaDadosFront(respostaBusca){
    try {
        respostaBusca = JSON.parse(respostaBusca)
        nomeCompleto.value = respostaBusca.nome
        telefone.value = respostaBusca.telefone
        rua.value = respostaBusca.endereco.rua
        numero.value = respostaBusca.endereco.numero
        bairro.value = respostaBusca.endereco.bairro
        estado.value = respostaBusca.endereco.estado
        cidade.value = respostaBusca.endereco.cidade
        cep.value = respostaBusca.endereco.cep
        } catch (errorQual) {
            console.log('Erro' + errorQual)
        }    
}
if(sessionStorage.getItem("requisicao")){
     enviaDadosFront(sessionStorage.getItem("requisicao"))
}else{
    (async ()=> {

        const resposta = await fetch('http://localhost/Sites/Repositorios/tcc/Sistema-de-pedidos-TCC/View/js/jsonEndereco.json')
        const respostaBusca = await resposta.text()
        if (!resposta.ok) {
            console.log("Erro de Solicitação na API!")
            return
        }        
    enviaDadosFront(respostaBusca)
})(btnSalvarEndere)
}