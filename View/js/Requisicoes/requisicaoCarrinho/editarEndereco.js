const dados = sessionStorage.getItem("requisicao");
console.log(dados);
let nomeCompleto = document.getElementById("nomeCompleto"),
  telefone = document.getElementById("telefone"),
  estado = document.getElementById("estado"),
  cidade = document.getElementById("cidade"),
  bairro = document.getElementById("bairro"),
  cep = document.getElementById("cep"),
  rua = document.getElementById("rua"),
  numero = document.getElementById("numero"),
  btnSalvarEndere = document.getElementById("btnSalvarEndere"); /*,
        aEdit = document.getElementById('aEdit')*/

function enviaDadosFront(respostaBusca) {
  try {
    let respostaBuscaJSON = JSON.parse(respostaBusca);
    console.log(respostaBuscaJSON);
    nomeCompleto.value = respostaBuscaJSON.nome;
    telefone.value = respostaBuscaJSON.telefone;
    rua.value = respostaBuscaJSON.endereco.rua;
    numero.value = respostaBuscaJSON.endereco.numero;
    bairro.value = respostaBuscaJSON.endereco.bairro;
    estado.value = respostaBuscaJSON.endereco.estado;
    cidade.value = respostaBuscaJSON.endereco.cidade;
    cep.value = respostaBuscaJSON.endereco.cep;
  } catch (errorQual) {
    console.log(respostaBusca);
    console.log("Erro" + errorQual);
    console.log(errorQual);
  }
}

if (dados) {
  enviaDadosFront(dados);
} else {
  (async () => {
    const resposta = await fetch(
      "http://localhost/Sites/Repositorios/tcc/Sistema-de-pedidos-TCC/View/js/jsonEndereco.json"
    );
    const respostaBusca = await resposta.text();
    if (!resposta.ok) {
      console.log("Erro de Solicitação na API!");
      return;
    }
    enviaDadosFront(respostaBusca);
  })();
}
