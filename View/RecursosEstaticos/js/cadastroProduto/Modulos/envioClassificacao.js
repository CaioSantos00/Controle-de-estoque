async function fetchBack(opcoes){
  let server = await fetch(...opcoes);
  return await server.text();
}

async function salvarClassificacao(nomeDela){
  let resposta = await fetchBack(opcoesRequisicoes.cadastro(nomeDela));
  return resposta == "cadastrou nova" ? true : false;
}

async function editarClassificacao(paraEditar, novoValor){
  let resposta = await fetchBack(opcoesRequisicoes.edicao(paraEditar, novoValor));
  return resposta == "tudo certo" ? true : false;
}
async function excluirClassificacao(paraExcluir){
  let resposta = await fetchBack(opcoesRequisicoes.excluir(paraExcluir));
  return resposta == "tudo certo" ? true : false;
}
async function consultarClassificacoes(){
  return await fetchBack(['envio/consultarClassificacoes'])
}
async function atualizarArqvClassificacoes(){
  return await fetchBack(['envio/atualizarClassificacoes']);
}
