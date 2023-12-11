const nomeEndereco = document.getElementById('nomeEndereco'),
    ruaEndereco = document.getElementById('rua'),
    numberEndereco = document.getElementById('numero'),
    bairroEndereco = document.getElementById('bairro'),
    estadoEndereco = document.getElementById('estado'),
    cityEndereco = document.getElementById('cidade'),
    titleEndereco = document.getElementsByClassName('titleEndereco')[0],
    aEdit = document.getElementById('aEdit');

function enviaDadosFront(respostaBusca, feito = true, daApi = false) {
    try {
        if(!feito) respostaBusca = JSON.parse(respostaBusca)

        if(daApi){
            bairroEndereco.value = respostaBusca.bairro
            estadoEndereco.value = respostaBusca.uf
            cityEndereco.value = respostaBusca.localidade
            return;
        }
        ruaEndereco.value = respostaBusca.endereco.rua
        nomeEndereco.value = respostaBusca.nome
        numberEndereco.value = respostaBusca.endereco.numero
    }
    catch (e) {
        console.log(e)
    }
}
function ativaConsultaPorCep() {
    const debounce = (func, delay) => {
        let timer;
        return function () {
            clearTimeout(timer);
            timer = setTimeout(() => {
                func.apply(this, arguments);
            }, delay);
        };
    };

    cep.addEventListener('input', debounce(async () => {
        console.log("Consulta de CEP ativada");
        let dados = await fetch(`https://viacep.com.br/ws/${cep.value.trim()}/json`);
        enviaDadosFront(await dados.json(), true, true);
    }, 1500));
}
function identificaOperacao(){
    let operacao;
    document.cookie.split(";").forEach((item) => {
        let coo = item.split("=")
        if(coo[0].trim() == "operacao") operacao = coo[1].trim()
    });
    return operacao
}
async function recuperaDadosEndereco(){
    let endereco = sessionStorage.getItem("endereco");
    let server = await fetch(`/enderecos/consultarEsse/${endereco ? endereco : "sem"}`)
    let response = await server.text();
    try {
        return JSON.parse(response)
    } catch (e) {
        return response;
    }
}
async function mudaNomeArqv(operacao){
    if(operacao == "cadastro"){
        titleEndereco.innerText = "Cadastrar endereco";
        ativaConsultaPorCep()        
        return;
    }
    let endereco = await recuperaDadosEndereco();
    console.log(endereco)
}

mudaNomeArqv(await identificaOperacao())
