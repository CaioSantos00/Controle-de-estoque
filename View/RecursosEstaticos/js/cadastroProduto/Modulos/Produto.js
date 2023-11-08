function extrairFotosInput(input){
  let fotos = [], qtd = input.files.length, x = 0;
  for(;x!=qtd;x++) fotos.push(input.files[x]);
  return fotos;
}

function coletarDadoVariacao(variacao){
  console.log(variacao)
  let elementos1 = Array.from(variacao.firstChild.getElementsByClassName("inputVari"));
  let elementos2 = Array.from(variacao.lastChild.getElementsByClassName("inputs"));
  console.log(elementos1)
  console.log(elementos2)
  let dados = {}, fotos = [];
      dados.preco = elementos1[0].value;
      dados.nome = elementos1[1].value;
      dados.descricao = elementos2[0].value;
      dados.fotos = extrairFotosInput(elementos2[1]);

  return dados;
}
function coletarDadosVariacoes(){
  let variacoes = divHoldVari.getElementsByClassName("cardsVariacoes"), qtd = variacoes.length, dadosVariacoes = [];
  console.log(variacoes)
  for(let x = 0;x != qtd; x++)
     dadosVariacoes.push(coletarDadoVariacao(variacoes[x]));

  return dadosVariacoes;
}
function coletarDadosPrincipais(){
  let retorno = [
    {"chave":"nome","valor":nomeProd.value},
    {"chave":"descricao","valor":document.getElementsByTagName('textarea')[0].value},
    {"chave":"fotosPrincipais", "valor":extrairFotosInput(fotosPrincipaisProd)}
  ];
  return retorno;
}
function coletarDadosFront(){
    return {
      "principais":coletarDadosPrincipais(),
      "secundarios" :coletarDadosVariacoes()
    };
}
